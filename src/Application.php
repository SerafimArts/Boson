<?php

declare(strict_types=1);

namespace Serafim\Boson;

use FFI\CData;
use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Dispatcher\EventListener;
use Serafim\Boson\Exception\NoDefaultWindowException;
use Serafim\Boson\FileSystem\VirtualFileSystemInterface;
use Serafim\Boson\Internal\Application\DebugEnvResolver;
use Serafim\Boson\Internal\Application\QuitHandler\PcntlQuitHandler;
use Serafim\Boson\Internal\Application\QuitHandler\QuitHandlerInterface;
use Serafim\Boson\Internal\Application\QuitHandler\WindowsQuitHandler;
use Serafim\Boson\Internal\Application\ThreadsCountResolver;
use Serafim\Boson\Internal\RequiresDealloc;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\WebView\WebViewInterface;
use Serafim\Boson\Window\Event\WindowClosed;
use Serafim\Boson\Window\Manager\WindowManager;
use Serafim\Boson\Window\WindowInterface;

final class Application implements ApplicationInterface
{
    public readonly ApplicationId $id;

    public readonly WindowManager $windows;

    public readonly EventListener $events;

    public WindowInterface $window {
        get => $this->windows->default
            ?? throw NoDefaultWindowException::becauseNoDefaultWindow();
    }

    public WebViewInterface $webview {
        get => $this->window->webview;
    }

    public VirtualFileSystemInterface $fs {
        get => $this->window->fs;
    }

    public readonly bool $isDebug;

    public private(set) bool $isRunning = false;

    /**
     * Shared WebView API library.
     */
    private readonly LibSaucer $api;

    /**
     * Gets status of quit handler registration.
     */
    private bool $quitHandlerIsRegistered = false;

    public function __construct(
        public readonly ApplicationCreateInfo $info = new ApplicationCreateInfo(),
        ?PsrEventDispatcherInterface $dispatcher = null,
    ) {
        $this->api = new LibSaucer($this->info->library);
        $this->isDebug = DebugEnvResolver::resolve($this->info->debug);
        $this->events = $this->createEventListener($dispatcher);
        $this->id = $this->createApplicationId($this->info->name, $this->info->threads);

        $this->windows = new WindowManager(
            api: $this->api,
            app: $this,
            info: $this->info->window,
            dispatcher: $this->events,
        );

        $this->registerDefaultEventListeners();
    }

    private function registerDefaultEventListeners(): void
    {
        $this->events->addEventListener(WindowClosed::class, $this->onWindowClose(...));
    }

    private function onWindowClose(): void
    {
        if ($this->info->quitOnClose && $this->windows->count() === 0) {
            $this->quit();
        }
    }

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
     * Stops an application execution.
     *
     * @api
     */
    public function quit(): void
    {
        $this->isRunning = false;
        $this->api->saucer_application_quit($this->id->ptr);
    }

    /**
     * @return iterable<array-key, QuitHandlerInterface>
     */
    private function getQuitHandlers(): iterable
    {
        yield new WindowsQuitHandler();
        yield new PcntlQuitHandler();
    }

    private function registerQuitHandlersIfNotRegistered(): void
    {
        if ($this->quitHandlerIsRegistered) {
            return;
        }

        foreach ($this->getQuitHandlers() as $handler) {
            if ($handler->isSupported === false) {
                continue;
            }

            $handler->register($this->quit(...));
        }

        $this->quitHandlerIsRegistered = true;
    }

    /**
     * @api
     */
    public function run(): void
    {
        if ($this->isRunning) {
            return;
        }

        $this->isRunning = true;

        $this->registerQuitHandlersIfNotRegistered();

        do {
            $this->api->saucer_application_run_once($this->id->ptr);
            \usleep(1);
        } while ($this->isRunning);
    }

    public function __destruct()
    {
        $this->api->saucer_application_quit($this->id->ptr);
        $this->api->saucer_application_free($this->id->ptr);
    }
}
