<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32;

use Serafim\WinUI\CreateInfo;
use Serafim\WinUI\Driver\Win32\Handle\Win32ClassHandle;
use Serafim\WinUI\Driver\Win32\Handle\Win32ClassHandleFactory;
use Serafim\WinUI\Driver\Win32\Handle\Win32InstanceHandle;
use Serafim\WinUI\Driver\Win32\Handle\Win32InstanceHandleFactory;
use Serafim\WinUI\Driver\Win32\Handle\Win32WindowHandle;
use Serafim\WinUI\Driver\Win32\Handle\Win32WindowHandleFactory;
use Serafim\WinUI\Driver\Win32\Lib\IconSize;
use Serafim\WinUI\Driver\Win32\Lib\ShowWindowCommand;
use Serafim\WinUI\Driver\Win32\Lib\User32;
use Serafim\WinUI\Driver\Win32\Lib\WindowMessage;
use Serafim\WinUI\Driver\Win32\Text\Converter;
use Serafim\WinUI\Driver\Win32\WebView2\ICoreWebView2Controller;
use Serafim\WinUI\Driver\Win32\WebView2\ICoreWebView2Environment;
use Serafim\WinUI\Driver\Win32\WebView2\WebView2Factory;
use Serafim\WinUI\Property\Property;
use Serafim\WinUI\Property\PropertyProviderTrait;
use Serafim\WinUI\Window\PositionInterface;
use Serafim\WinUI\Window\SizeInterface;
use Serafim\WinUI\WindowInterface;

final class Win32Window implements WindowInterface
{
    use PropertyProviderTrait;

    private string $title;

    private readonly User32 $user32;

    private readonly Converter $text;

    private readonly Win32InstanceHandle $instance;

    private readonly Win32ClassHandle $class;

    public readonly Win32WindowHandle $handle;

    private readonly MessageDispatcher $messages;

    private readonly IconLoader $icons;

    /**
     * @var non-empty-string|null
     */
    private ?string $currentIcon = null;

    private Win32Size $win32Size;

    private Win32Position $win32Position;

    public function __construct(
        CreateInfo $info,
        Win32InstanceHandleFactory $modules = new Win32InstanceHandleFactory(),
        Win32ClassHandleFactory $classes = new Win32ClassHandleFactory(),
        Win32WindowHandleFactory $windows = new Win32WindowHandleFactory(),
        WebView2Factory $webview = new WebView2Factory(),
        ?User32 $user32 = null,
        ?Converter $text = null,
    ) {
        $this->title = $info->title;
        $this->instance = $modules->getCurrentInstanceHandle();
        $this->class = $classes->create($this->instance, $this);
        $this->handle = $windows->create($this->class, $info);
        $this->user32 = $user32 ?? User32::getInstance();
        $this->text = $text ?? Text::getInstance();

        $this->messages = new MessageDispatcher();
        $this->icons = new IconLoader($this->handle, $this->user32, $this->text);

        $rect = new Win32Rect($this->user32, $this->handle);
        $this->win32Size = new Win32Size($rect);
        $this->win32Position = new Win32Position($rect);

        $webview->create(function (ICoreWebView2Environment $env) {
            $status = $env->createCoreWebView2Controller(
                handle: $this->handle,
                then: function (ICoreWebView2Controller $host) {
                    $webview = $host->getCoreWebView();

                    dump($webview);
                },
            );

            if ($status !== 0) {
                throw new \RuntimeException('WebView controller creation failed');
            }
        });
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
    }

    public function hide(): void
    {
        $this->user32->ShowWindow($this->handle->ptr, ShowWindowCommand::SW_HIDE);
    }

    public function close(): void
    {
        $this->user32->DestroyWindow($this->handle->ptr);
    }

    public function peek(): void
    {
        $this->messages->peek($this->handle);
    }
}
