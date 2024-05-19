<?php

declare(strict_types=1);

namespace Local\Driver\Win32;

use FFI\CData;
use Local\Driver\Win32\Lib\User32;
use Local\WebView2\ICoreWebView2;
use Local\WebView2\ICoreWebView2Controller;
use Local\WebView2\ICoreWebView2Environment;
use Local\WebView2\WebView2;
use Serafim\WinUI\CreateInfo;
use Serafim\WinUI\Event\WebViewCreatedEvent;
use Serafim\WinUI\Event\WindowCloseEvent;
use Serafim\WinUI\Event\WindowResizeEvent;
use Serafim\WinUI\Exception\WebView2NotAvailableException;
use Serafim\WinUI\Window\WebViewInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Win32WebView implements WebViewInterface
{
    private ?ICoreWebView2 $core = null;

    private readonly CData $rect;

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
                    $this->core = $host->coreWebView2;

                    $this->updateSettings();
                    $this->updateWindowSize();

                    $this->events->dispatch(new WebViewCreatedEvent(
                        target: $this->window,
                        webview: $this,
                    ));
                },
            );
        });
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
        $this->user32->GetClientRect($this->window->handle->ptr, \FFI::addr($this->rect));

        $this->core->host->bounds = $this->rect;
    }

    private function updateSettings(): void
    {
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

    public function navigate(string $uri): void
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
