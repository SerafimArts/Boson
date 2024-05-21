<?php

declare(strict_types=1);

namespace Local\Driver\Win32;

use FFI\CData;
use JetBrains\PhpStorm\Language;
use Local\Driver\Win32\Lib\User32;
use Local\Property\Attribute\MapGetter;
use Local\Property\Attribute\MapSetter;
use Local\Property\ContainProperties;
use Local\WebView2\Exception\WebViewNotAvailableException;
use Local\WebView2\Handler;
use Local\WebView2\ICoreWebView2;
use Local\WebView2\ICoreWebView2Controller;
use Local\WebView2\ICoreWebView2Environment;
use Local\WebView2\WebView2;
use Serafim\Boson\Event\WebView\WebViewCreatedEvent;
use Serafim\Boson\Event\WebView\WebViewMessageReceivedEvent;
use Serafim\Boson\Event\WebView\WebViewNavigationCompleted;
use Serafim\Boson\Event\WebView\WebViewNavigationFailed;
use Serafim\Boson\Event\WebView\WebViewNavigationStarted;
use Serafim\Boson\Event\Window\WindowClosedEvent;
use Serafim\Boson\Event\Window\WindowResizeEvent;
use Serafim\Boson\Exception\WebViewNavigationException;
use Serafim\Boson\Window\WebViewInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Win32WebView implements WebViewInterface
{
    use ContainProperties;

    public ?ICoreWebView2 $core = null;

    public readonly CData $rect;

    public function __construct(
        private readonly User32 $user32,
        public readonly Win32Window $window,
        private readonly EventDispatcherInterface $events,
        private readonly WebView2 $webview,
    ) {
        // @phpstan-ignore-next-line
        $this->rect = $this->user32->new('RECT');

        $this->addEventListeners();

        $this->webview->createCoreWebView2Environment()
            ->then(function (ICoreWebView2Environment $env) {
                $env->createCoreWebView2Controller($this->window->handle->ptr)
                    ->then($this->onControllerCreated(...));
            });
    }

    private function onControllerCreated(ICoreWebView2Controller $host): void
    {
        $this->core = $core = $host->coreWebView2;

        $this->updateSettings();
        $this->updateWindowSize();
        $this->delegateEventListeners($core);

        $this->events->dispatch(new WebViewCreatedEvent(
            subject: $this,
        ));
    }

    private function delegateEventListeners(ICoreWebView2 $core): void
    {
        $core->onNavigationStarting(function (Handler\NavigationStartingEventArgs $e): void {
            $this->events->dispatch(new WebViewNavigationStarted(
                subject: $this,
                uri: $e->uri,
            ));
        });

        $core->onFrameNavigationStarting(function (Handler\NavigationStartingEventArgs $e): void {
            $this->events->dispatch(new WebViewNavigationStarted(
                subject: $this,
                uri: $e->uri,
            ));
        });

        $core->onNavigationCompleted(function (Handler\NavigationCompletedEventArgs $e): void {
            $this->events->dispatch($e->isSuccess()
                ? new WebViewNavigationCompleted($this)
                : new WebViewNavigationFailed(
                    subject: $this,
                    error: WebViewNavigationException::fromBackedEnum($e->webErrorStatus),
                ));
        });

        $core->onFrameNavigationCompleted(function (Handler\NavigationCompletedEventArgs $e): void {
            $this->events->dispatch($e->isSuccess()
                ? new WebViewNavigationCompleted($this)
                : new WebViewNavigationFailed(
                    subject: $this,
                    error: WebViewNavigationException::fromBackedEnum($e->webErrorStatus),
                ));
        });

        $core->onWebMessageReceived(function (Handler\WebMessageReceivedEventArgs $e): void {
            try {
                $data = \json_decode($e->webMessageAsJson, true, flags: \JSON_THROW_ON_ERROR);
            } catch (\JsonException) {
                return;
            }

            $this->events->dispatch(new WebViewMessageReceivedEvent($this, $data));
        });
    }

    private function addEventListeners(): void
    {
        $this->events->addListener(WindowResizeEvent::class, $this->onWindowResize(...));
        $this->events->addListener(WindowClosedEvent::class, $this->onWindowClose(...));
    }

    private function removeEventListeners(): void
    {
        $this->events->removeListener(WindowResizeEvent::class, $this->onWindowResize(...));
        $this->events->removeListener(WindowClosedEvent::class, $this->onWindowClose(...));
    }

    private function onWindowClose(WindowClosedEvent $e): void
    {
        if ($e->subject !== $this->window) {
            return;
        }

        $this->removeEventListeners();
    }

    private function onWindowResize(WindowResizeEvent $e): void
    {
        if ($e->subject !== $this->window) {
            return;
        }

        $this->updateWindowSize();
    }

    private function updateWindowSize(): void
    {
        if ($this->core === null) {
            return;
        }

        // @phpstan-ignore-next-line
        $this->user32->GetClientRect($this->window->handle->ptr, \FFI::addr($this->rect));

        $this->core->host->bounds = $this->rect;
    }

    private function updateSettings(): void
    {
        if ($this->core === null) {
            return;
        }

        $settings = $this->core->settings;

        $settings->isScriptEnabled = true;
        $settings->isWebMessageEnabled = true;
        $settings->isStatusBarEnabled = false;
        $settings->isZoomControlEnabled = false;
        $settings->areDefaultContextMenusEnabled = false;
        $settings->areDefaultScriptDialogsEnabled = true;
        $settings->areDevToolsEnabled = $this->window->info->debug;
    }

    public function isInitialized(): bool
    {
        return $this->core !== null;
    }

    public function load(string $content): void
    {
        if ($this->core === null) {
            throw WebViewNotAvailableException::createWithMessage('Not Initialized');
        }

        $this->core->navigateToString($content);
    }

    public function exec(#[Language('JavaScript')] string $script): void
    {
        if ($this->core === null) {
            throw WebViewNotAvailableException::createWithMessage('Not Initialized');
        }

        $this->core->executeScript($script);
    }

    /**
     * @api
     */
    #[MapGetter('uri')]
    public function getUri(): string
    {
        return $this->core?->getSource()
            ?? 'about:blank';
    }

    /**
     * @api
     */
    #[MapSetter('uri')]
    public function setUri(string $uri): void
    {
        if ($this->core === null) {
            throw WebViewNotAvailableException::createWithMessage('Not Initialized');
        }

        $this->core->navigate($uri);
    }

    public function __destruct()
    {
        $this->removeEventListeners();
    }
}
