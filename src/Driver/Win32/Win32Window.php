<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32;

use Serafim\WinUI\CreateInfo;
use Serafim\WinUI\Driver\Win32\Handle\Win32ClassHandleFactory;
use Serafim\WinUI\Driver\Win32\Handle\Win32InstanceHandleFactory;
use Serafim\WinUI\Driver\Win32\Handle\Win32WindowHandle;
use Serafim\WinUI\Driver\Win32\Handle\Win32WindowHandleFactory;
use Serafim\WinUI\Driver\Win32\Lib\IconSize;
use Serafim\WinUI\Driver\Win32\Lib\ShowWindowCommand;
use Serafim\WinUI\Driver\Win32\Lib\User32;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;
use Serafim\WinUI\Driver\Win32\Lib\WindowMessage;
use Serafim\WinUI\Driver\Win32\Text\Converter;
use Serafim\WinUI\Driver\Win32\WebView2\ICoreWebView2;
use Serafim\WinUI\Driver\Win32\WebView2\ICoreWebView2Controller;
use Serafim\WinUI\Driver\Win32\WebView2\ICoreWebView2Environment;
use Serafim\WinUI\Event\WindowResizeEvent;
use Serafim\WinUI\Property\Property;
use Serafim\WinUI\Property\PropertyProviderTrait;
use Serafim\WinUI\Window\PositionInterface;
use Serafim\WinUI\Window\SizeInterface;
use Serafim\WinUI\WindowInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Win32Window implements WindowInterface
{
    use PropertyProviderTrait;

    private string $title;

    private readonly User32 $user32;

    private readonly Converter $text;

    public readonly Win32WindowHandle $handle;

    private readonly MessageDispatcher $messages;

    private readonly IconLoader $icons;

    /**
     * @var non-empty-string|null
     */
    private ?string $currentIcon = null;

    private ?ICoreWebView2 $webview = null;

    private Win32Size $win32Size;

    private Win32Position $win32Position;

    private Win32Rect $rect;

    public function __construct(
        private readonly EventDispatcherInterface $events,
        private readonly CreateInfo $info,
        WebView2 $webview,
        Win32InstanceHandleFactory $modules,
        Win32ClassHandleFactory $classes,
        Win32WindowHandleFactory $windows,
        ?User32 $user32 = null,
        ?Converter $text = null,
    ) {
        $this->title = $info->title;

        $this->handle = $windows->create(
            info: $info,
            class: $classes->create(
                info: $info,
                instance: $modules->getCurrentInstanceHandle(),
                window: $this,
            ),
        );

        $this->user32 = $user32 ?? User32::getInstance();
        $this->text = $text ?? Text::getInstance();

        $this->messages = new MessageDispatcher();
        $this->icons = new IconLoader($this->handle, $this->user32, $this->text);

        $this->rect = new Win32Rect($this->user32, $this->handle);
        $this->win32Size = new Win32Size($this->rect);
        $this->win32Position = new Win32Position($this->rect);

        $webview->createCoreWebView2Environment(function (ICoreWebView2Environment $env): void {
            $env->createCoreWebView2Controller($this->handle, function (ICoreWebView2Controller $host): void {
                $this->webview = $host->coreWebView2;

                $this->updateWebViewSettings();
                $this->updateWebViewSize();

                $this->webview->navigate('https://github.com/SerafimArts/WinUI');
            });
        });

        $this->addEventListeners();
    }

    private function addEventListeners(): void
    {
        $this->events->addListener(WindowResizeEvent::class, $this->onWindowResize(...));
    }

    private function removeEventListeners(): void
    {
        $this->events->removeListener(WindowResizeEvent::class, $this->onWindowResize(...));
    }

    private function onWindowResize(WindowResizeEvent $e): void
    {
        if ($e->target !== $this) {
            return;
        }

        $this->updateWebViewSize();
    }

    /**
     * Add a few settings for the webview.
     * The demo step is redundant since the values are the default settings.
     */
    private function updateWebViewSettings(): void
    {
        if ($this->webview === null) {
            return;
        }

        $settings = $this->webview->settings;
        $settings->isScriptEnabled = true;
        $settings->isWebMessageEnabled = true;
        $settings->isStatusBarEnabled = false;
        $settings->isZoomControlEnabled = false;
        $settings->areDefaultContextMenusEnabled = false;
        $settings->areDefaultScriptDialogsEnabled = true;
        $settings->areDevToolsEnabled = $this->info->debug;
    }

    private function updateWebViewSize(): void
    {
        if ($this->webview === null) {
            return;
        }

        // Resize WebView to fit the bounds of the parent window
        $this->webview->host->bounds = $this->rect->get();
    }

    /**
     * @return Property<string, string>
     */
    protected function title(): Property
    {
        return Property::new(
            get: fn(): string => $this->title,
            set: function (string $title): void {
                $wide = $this->text->wide($this->title = $title);

                $this->user32->SetWindowTextW($this->handle->ptr, $wide);
            },
        );
    }

    /**
     * @return Property<Win32Size, SizeInterface>
     */
    protected function size(): Property
    {
        return Property::new(
            get: fn(): Win32Size => $this->win32Size,
            set: fn(SizeInterface $size): null => $this->win32Size->set($size)
        );
    }

    /**
     * @return Property<Win32Position, PositionInterface>
     */
    protected function position(): Property
    {
        return Property::new(
            get: fn(): Win32Position => $this->win32Position,
            set: fn(PositionInterface $position): null => $this->win32Position->set($position)
        );
    }

    /**
     * @return Property<non-empty-string|null, string|null>
     */
    protected function icon(): Property
    {
        return Property::new(
            get: fn(): ?string => $this->currentIcon,
            set: $this->setIcon(...),
        );
    }

    private function setIcon(?string $pathname): void
    {
        if ($pathname === '') {
            $pathname = null;
        }

        $icon = null;

        if ($pathname === null && $this->currentIcon === null) {
            return;
        }

        if ($pathname !== null) {
            $icon = $this->user32->cast(
                type: 'LPARAM',
                // @phpstan-ignore-next-line
                ptr: \FFI::addr($this->user32->cast(
                    type: 'LPARAM',
                    ptr: $this->icons->load($pathname),
                )),
            );
        }

        $this->user32->SendMessageW(
            $this->handle->ptr,
            WindowMessage::WM_SETICON,
            IconSize::ICON_SMALL,
            $icon?->cdata,
        );

        $this->currentIcon = $pathname;

        if ($icon !== null) {
            $this->user32->DestroyIcon(\FFI::addr($icon));
        }
    }

    public function show(): void
    {
        $this->user32->ShowWindow($this->handle->ptr, ShowWindowCommand::SW_SHOW);
        $this->user32->UpdateWindow($this->handle->ptr);
    }

    public function hide(): void
    {
        $this->user32->ShowWindow($this->handle->ptr, ShowWindowCommand::SW_HIDE);
    }

    public function close(): void
    {
        $this->removeEventListeners();
        $this->user32->DestroyWindow($this->handle->ptr);
    }

    public function peek(): void
    {
        $this->messages->peek($this->handle);
    }
}
