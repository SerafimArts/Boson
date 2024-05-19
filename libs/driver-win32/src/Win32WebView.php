<?php

declare(strict_types=1);

namespace Local\Driver\Win32;

use FFI\CData;
use Local\Driver\Win32\Exception\WebView2NotAvailableException;
use Local\Driver\Win32\Lib\User32;
use Local\Property\Attribute\MapGetter;
use Local\Property\Attribute\MapSetter;
use Local\Property\ContainProperties;
use Local\WebView2\Handler;
use Local\WebView2\ICoreWebView2;
use Local\WebView2\ICoreWebView2Controller;
use Local\WebView2\ICoreWebView2Environment;
use Local\WebView2\WebView2;
use Serafim\Boson\CreateInfo;
use Serafim\Boson\Event\WebViewCreatedEvent;
use Serafim\Boson\Event\WebViewNavigated;
use Serafim\Boson\Event\WebViewNavigationCompleted;
use Serafim\Boson\Event\WebViewNavigationFailed;
use Serafim\Boson\Event\WebViewNavigationStarting;
use Serafim\Boson\Event\WindowCloseEvent;
use Serafim\Boson\Event\WindowResizeEvent;
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
        private readonly Win32Window $window,
        private readonly CreateInfo $info,
        private readonly EventDispatcherInterface $events,
        private readonly WebView2 $webview,
    ) {
        // @phpstan-ignore-next-line
        $this->rect = $this->user32->new('RECT');

        $this->addEventListeners();

        $this->webview->createCoreWebView2Environment(function (ICoreWebView2Environment $env): void {
            $env->createCoreWebView2Controller(
                window: $this->window->handle->ptr,
                then: function (ICoreWebView2Controller $host): void {
                    $this->core = $core = $host->coreWebView2;

                    $this->updateSettings();
                    $this->updateWindowSize();
                    $this->delegateEventListeners($core);

                    $this->events->dispatch(new WebViewCreatedEvent(
                        target: $this->window,
                        webview: $this,
                    ));
                },
            );
        });
    }

    private function delegateEventListeners(ICoreWebView2 $core): void
    {
        $core->onNavigationStarting(function (Handler\NavigationStartingEventArgs $e): void {
            $this->events->dispatch(new WebViewNavigationStarting(
                target: $this->window,
                webview: $this,
                uri: $e->uri,
            ));
        });

        $core->onFrameNavigationStarting(function (Handler\NavigationStartingEventArgs $e): void {
            $this->events->dispatch(new WebViewNavigationStarting(
                target: $this->window,
                webview: $this,
                uri: $e->uri,
            ));
        });

        $core->onNavigationCompleted(function (Handler\NavigationCompletedEventArgs $e): void {
            $this->events->dispatch($this->getNavigatedEvent($e));
        });

        $core->onFrameNavigationCompleted(function (Handler\NavigationCompletedEventArgs $e): void {
            $this->events->dispatch($this->getNavigatedEvent($e));
        });
    }

    private function getNavigatedEvent(Handler\NavigationCompletedEventArgs $e): WebViewNavigated
    {
        if ($e->isSuccess()) {
            return new WebViewNavigationCompleted($this->window, $this);
        }

        return new WebViewNavigationFailed(
            target: $this->window,
            webview: $this,
            error: WebViewNavigationException::fromBackedEnum($e->webErrorStatus),
        );
    }

    private function addEventListeners(): void
    {
        $this->events->addListener(WindowResizeEvent::class, $this->onWindowResize(...));
        $this->events->addListener(WindowCloseEvent::class, $this->onWindowClose(...));
    }

    private function removeEventListeners(): void
    {
        $this->events->removeListener(WindowResizeEvent::class, $this->onWindowResize(...));
        $this->events->removeListener(WindowCloseEvent::class, $this->onWindowClose(...));
    }

    private function onWindowClose(WindowCloseEvent $e): void
    {
        if ($e->target !== $this->window) {
            return;
        }

        $this->removeEventListeners();
    }

    private function onWindowResize(WindowResizeEvent $e): void
    {
        if ($e->target !== $this->window) {
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
        $settings->areDevToolsEnabled = $this->info->debug;
    }

    public function isInitialized(): bool
    {
        return $this->core !== null;
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
            throw WebView2NotAvailableException::createWithMessage('Not Initialized');
        }

        $this->core->navigate($uri);
    }

    public function __destruct()
    {
        $this->removeEventListeners();
    }
}
