<?php

declare(strict_types=1);

namespace Serafim\Boson;

use FFI\CData;
use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;
use Serafim\Boson\Application\DebugEnvResolver;
use Serafim\Boson\Application\QuitHandler\PcntlQuitHandler;
use Serafim\Boson\Application\QuitHandler\QuitHandlerInterface;
use Serafim\Boson\Application\QuitHandler\WindowsQuitHandler;
use Serafim\Boson\Application\ThreadsCountResolver;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Dispatcher\EventListener;
use Serafim\Boson\FileSystem\VirtualFileSystemInterface;
use Serafim\Boson\Kernel\LibSaucer;
use Serafim\Boson\Shared\Attribute\RequiresDealloc;
use Serafim\Boson\WebView\WebViewInterface;
use Serafim\Boson\Window\Manager\WindowFactoryInterface;
use Serafim\Boson\Window\Manager\WindowManager;
use Serafim\Boson\Window\Manager\WindowManagerInterface;
use Serafim\Boson\Window\WindowInterface;

final class Application
{
    /**
     * An application identifier.
     */
    public readonly ApplicationId $id;

    /**
     * If the value is set to {@see true}, then debugging is enabled
     * or disabled instead.
     */
    public readonly bool $debug;

    /**
     * Shared WebView API library.
     *
     * @internal If you see this, I forgot to make this field private
     *           while debugging the app =)
     */
    public readonly LibSaucer $api;

    /**
     * Gets application running state.
     */
    public private(set) bool $running = false;

    /**
     * Gets status of quit handler registration.
     */
    private bool $quitHandlerIsRegistered = false;

    /**
     * Contains windows list and methods for working with windows.
     */
    public readonly WindowManagerInterface&WindowFactoryInterface $windows;

    /**
     * Gets default (main) application Window.
     *
     * Note: Property will throw an {@see \LogicException} in case the default
     *       Window was already closed and removed earlier.
     */
    public WindowInterface $window {
        get => $this->windows->default ?? throw new \LogicException(
            message: 'There is no default window available,'
                . ' perhaps it was removed (closed) earlier',
        );
    }

    /**
     * Gets WebView of the default (main) application Window.
     *
     * Note: Property will throw an {@see \LogicException} in case the default
     *       Window was already closed and removed earlier.
     */
    public WebViewInterface $webview {
        get => $this->window->webview;
    }

    /**
     * Gets VFS of the default (main) application window.
     *
     * Note: Property will throw an {@see \LogicException} in case the default
     *       Window was already closed and removed earlier.
     */
    public VirtualFileSystemInterface $fs {
        get => $this->window->fs;
    }

    /**
     * Contains application aware event subscriptions.
     */
    private readonly EventListener $events;

    public function __construct(
        public readonly ApplicationCreateInfo $info = new ApplicationCreateInfo(),
        ?PsrEventDispatcherInterface $dispatcher = null,
    ) {
        $this->api = new LibSaucer($this->info->library);
        $this->debug = DebugEnvResolver::resolve($this->info->debug);
        $this->events = $this->createEventListener($dispatcher);
        $this->id = $this->createApplicationId($this->info->name, $this->info->threads);

        $this->windows = new WindowManager(
            api: $this->api,
            app: $this,
            info: $this->info->window,
            dispatcher: $this->events,
        );
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
        $this->api->saucer_application_quit($this->id->ptr);
        $this->running = false;
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
        if ($this->running) {
            return;
        }

        $this->running = true;

        $this->registerQuitHandlersIfNotRegistered();

        while ($this->running) {
            $this->api->saucer_application_run_once($this->id->ptr);
            \usleep(1);
        }
    }

    public function __destruct()
    {
        $this->api->saucer_application_quit($this->id->ptr);
        $this->api->saucer_application_free($this->id->ptr);
    }
}
