<?php

declare(strict_types=1);

namespace Serafim\Boson;

use FFI\CData;
use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Dispatcher\EventListener;
use Serafim\Boson\Exception\NoDefaultWindowException;
use Serafim\Boson\Internal\Application\DebugEnvResolver;
use Serafim\Boson\Internal\Application\DeferRunner\DeferRunnerInterface;
use Serafim\Boson\Internal\Application\DeferRunner\NativeShutdownFunctionRunner;
use Serafim\Boson\Internal\Application\ProcessUnlockPlaceholder;
use Serafim\Boson\Internal\Application\QuitHandler\PcntlQuitHandler;
use Serafim\Boson\Internal\Application\QuitHandler\QuitHandlerInterface;
use Serafim\Boson\Internal\Application\QuitHandler\WindowsQuitHandler;
use Serafim\Boson\Internal\Application\ThreadsCountResolver;
use Serafim\Boson\Internal\RequiresDealloc;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\WebView\WebViewInterface;
use Serafim\Boson\Window\Event\WindowClosed;
use Serafim\Boson\Window\Manager\WindowManager;
use Serafim\Boson\Window\Manager\WindowManagerInterface;
use Serafim\Boson\Window\WindowInterface;

final class Application implements ApplicationInterface
{
    public readonly ApplicationId $id;

    public readonly WindowManager $windows;

    public readonly EventListener $events;

    /**
     * Facade property.
     *
     * Provides more convenient and faster access
     * to the {@see WindowManagerInterface::$default}
     * subsystem from {@see $windows} property.
     */
    public WindowInterface $window {
        /**
         * Gets the default window of the application.
         *
         * @throws NoDefaultWindowException in case there is not a single window
         */
        get => $this->windows->default
            ?? throw NoDefaultWindowException::becauseNoDefaultWindow();
    }

    /**
     * Facade property.
     *
     * Provides more convenient and faster access
     * to the {@see WindowInterface::$webview}
     * subsystem from {@see $window} property.
     */
    public WebViewInterface $webview {
        /**
         * Gets the WebView instance associated with the default window.
         *
         * @throws NoDefaultWindowException in case there is not a single window
         */
        get => $this->window->webview;
    }

    public readonly bool $isDebug;

    /**
     * Indicates whether the application is currently running.
     */
    public private(set) bool $isRunning = false;

    /**
     * Indicates whether the application was ever running
     */
    private bool $wasEverRunning = false;

    /**
     * Shared WebView API library.
     *
     * @internal Not safe, you can get segfault, use
     *           this low-level API at your own risk!
     */
    public readonly LibSaucer $api;

    /**
     * Gets status of quit handler registration.
     */
    private bool $quitHandlerIsRegistered = false;

    /**
     * Gets status of defer runner registration.
     */
    private bool $deferRunnerIsRegistered = false;

    private readonly ProcessUnlockPlaceholder $placeholder;

    /**
     * @param PsrEventDispatcherInterface|null $dispatcher an optional event
     *        dispatcher for handling application events
     */
    public function __construct(
        /**
         * Application configuration DTO.
         */
        public readonly ApplicationCreateInfo $info = new ApplicationCreateInfo(),
        ?PsrEventDispatcherInterface $dispatcher = null,
    ) {
        $this->api = new LibSaucer($this->info->library);
        $this->isDebug = DebugEnvResolver::resolve($this->info->debug);
        $this->events = $this->createEventListener($dispatcher);
        $this->id = $this->createApplicationId($this->info->name, $this->info->threads);

        $this->placeholder = new ProcessUnlockPlaceholder(
            api: $this->api,
            app: $this,
        );

        $this->windows = new WindowManager(
            api: $this->api,
            app: $this,
            placeholder: $this->placeholder,
            info: $this->info->window,
            dispatcher: $this->events,
        );

        $this->registerDefaultEventListeners();

        if ($this->info->autorun) {
            $this->registerDeferRunnerIfNotRegistered();
        }
    }

    /**
     * Registers default event listeners for the application.
     *
     * This includes handling window close events.
     */
    private function registerDefaultEventListeners(): void
    {
        $this->events->addEventListener(WindowClosed::class, $this->onWindowClose(...));
    }

    /**
     * Handles the window close event.
     *
     * If {@see $quitOnClose} is enabled ({@see true}) and
     * all windows are closed, the application will quit.
     */
    private function onWindowClose(): void
    {
        if ($this->info->quitOnClose && $this->windows->count() === 0) {
            $this->quit();
        }
    }

    /**
     * Creates local (application-aware) event listener
     * based on the provided dispatcher.
     */
    private function createEventListener(?PsrEventDispatcherInterface $dispatcher): EventListener
    {
        if ($dispatcher === null) {
            return new EventListener();
        }

        return new DelegateEventListener($dispatcher);
    }

    /**
     * Creates a new application ID
     *
     * @param non-empty-string $name
     * @param int<1, 32767>|null $threads
     */
    private function createApplicationId(string $name, ?int $threads): ApplicationId
    {
        return ApplicationId::fromAppHandle(
            api: $this->api,
            handle: $this->createApplicationPointer($name, $threads),
            name: $name,
        );
    }

    /**
     * Creates a new application instance pointer.
     *
     * @param non-empty-string $name
     * @param int<1, 32767>|null $threads
     */
    #[RequiresDealloc]
    private function createApplicationPointer(string $name, ?int $threads): CData
    {
        $options = $this->createApplicationOptionsPointer($name, $threads);

        try {
            return $this->api->saucer_application_init($options);
        } finally {
            $this->api->saucer_options_free($options);
        }
    }

    /**
     * Creates a new application options pointer.
     *
     * @param non-empty-string $name
     * @param int<1, 32767>|null $threads
     */
    #[RequiresDealloc]
    private function createApplicationOptionsPointer(string $name, ?int $threads): CData
    {
        $options = $this->api->saucer_options_new($name);

        $threads = ThreadsCountResolver::resolve($threads);
        if ($threads !== null) {
            $this->api->saucer_options_set_threads($options, $threads);
        }

        return $options;
    }

    /**
     * Quits the application, stopping the main
     * loop and releasing resources.
     */
    public function quit(): void
    {
        $this->isRunning = false;
        $this->api->saucer_application_quit($this->id->ptr);
    }

    /**
     * Returns a list of quit handlers (intercepts alternative
     * application shutdown commands) for the application.
     *
     * @return iterable<array-key, QuitHandlerInterface>
     */
    private function getQuitHandlers(): iterable
    {
        yield new WindowsQuitHandler();
        yield new PcntlQuitHandler();
    }

    /**
     * Registers quit handlers if they haven't been registered yet.
     *
     * This ensures that the application can be properly terminated.
     */
    private function registerQuitHandlersIfNotRegistered(): void
    {
        if ($this->quitHandlerIsRegistered) {
            return;
        }

        foreach ($this->getQuitHandlers() as $handler) {
            if ($handler->isSupported === false) {
                continue;
            }

            // Register EVERY quit handler
            $handler->register($this->quit(...));
        }

        $this->quitHandlerIsRegistered = true;
    }

    /**
     * Returns a list of defer runners for the application.
     *
     * @return iterable<array-key, DeferRunnerInterface>
     */
    private function getDeferRunners(): iterable
    {
        yield new NativeShutdownFunctionRunner();
    }

    /**
     * Registers a defer runner if none has been registered yet.
     *
     * This allows the application to be started automatically
     * after script execution.
     */
    private function registerDeferRunnerIfNotRegistered(): void
    {
        if ($this->deferRunnerIsRegistered) {
            return;
        }

        foreach ($this->getDeferRunners() as $runner) {
            if ($runner->isSupported === false) {
                continue;
            }

            // Register FIRST deferred runner
            $runner->register($this->runIfNotEverRunning(...));
            break;
        }

        $this->deferRunnerIsRegistered = true;
    }

    /**
     * Runs the application if it has never been run before.
     *
     * This is used by the defer runner to start
     * the application automatically.
     */
    private function runIfNotEverRunning(): void
    {
        if ($this->wasEverRunning) {
            return;
        }

        $this->run();
    }

    /**
     * Runs the application, starting the main event loop.
     *
     * This method blocks main thread until the
     * application is quit.
     */
    public function run(): void
    {
        if ($this->isRunning) {
            return;
        }

        $this->isRunning = true;
        $this->wasEverRunning = true;

        $this->registerQuitHandlersIfNotRegistered();

        do {
            $this->api->saucer_application_run_once($this->id->ptr);

            \usleep(1);
        } while ($this->isRunning);
    }

    /**
     * Destructor for the Application class.
     *
     * Ensures that all resources are properly released
     * when the application is destroyed.
     */
    public function __destruct()
    {
        $this->api->saucer_application_quit($this->id->ptr);
        $this->api->saucer_application_free($this->id->ptr);
    }
}
