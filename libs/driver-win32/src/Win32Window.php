<?php

declare(strict_types=1);

namespace Local\Driver\Win32;

use Local\Com\WideString;
use Local\Driver\Win32\Handle\Win32ClassHandleFactory;
use Local\Driver\Win32\Handle\Win32InstanceHandle;
use Local\Driver\Win32\Handle\Win32WindowHandle;
use Local\Driver\Win32\Handle\Win32WindowHandleFactory;
use Local\Driver\Win32\Lib\IconSize;
use Local\Driver\Win32\Lib\ShowWindowCommand;
use Local\Driver\Win32\Lib\User32;
use Local\Driver\Win32\Lib\WindowMessage;
use Local\Driver\Win32\Window\IconLoader;
use Local\Driver\Win32\Window\Win32Position;
use Local\Driver\Win32\Window\Win32Size;
use Local\Property\Attribute\MapGetter;
use Local\Property\Attribute\MapSetter;
use Local\Property\ContainProperties;
use Local\WebView2\WebView2;
use Serafim\Boson\CreateInfo;
use Serafim\Boson\Event\WindowCreatedEvent;
use Serafim\Boson\Window\PositionInterface;
use Serafim\Boson\Window\SizeProviderInterface;
use Serafim\Boson\WindowInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Win32Window implements WindowInterface
{
    use ContainProperties;

    public readonly Win32WindowHandle $handle;

    public readonly Win32WebView $webview;

    private string $title;

    /**
     * @var non-empty-string|null
     */
    private ?string $currentIcon = null;

    private readonly IconLoader $icons;

    private readonly Win32Size $sizeProperty;

    private readonly Win32Position $positionProperty;

    public function __construct(
        EventDispatcherInterface $events,
        CreateInfo $info,
        Win32InstanceHandle $instance,
        Win32ClassHandleFactory $classes,
        Win32WindowHandleFactory $windows,
        private readonly User32 $user32,
        WebView2 $webView2,
    ) {
        $this->title = $info->title;

        $this->handle = $windows->create(
            info: $info,
            class: $classes->create(
                info: $info,
                instance: $instance,
                window: $this,
            ),
        );

        $this->icons = new IconLoader($this->handle, $this->user32);
        $this->sizeProperty = new Win32Size($this->user32, $this);
        $this->positionProperty = new Win32Position($this->user32, $this);

        $this->webview = new Win32WebView(
            user32: $this->user32,
            window: $this,
            info: $info,
            events: $events,
            webview: $webView2,
        );

        $events->dispatch(new WindowCreatedEvent($this));
    }

    /**
     * @api
     */
    #[MapGetter('title')]
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @api
     */
    #[MapSetter('title')]
    public function setTitle(string $title): void
    {
        $encoded = WideString::toWideString($this->title = $title);

        $this->user32->SetWindowTextW($this->handle->ptr, $encoded);
    }

    /**
     * @api
     */
    #[MapGetter('size')]
    public function getSize(): Win32Size
    {
        return $this->sizeProperty;
    }

    /**
     * @api
     */
    #[MapSetter('size')]
    public function setSize(SizeProviderInterface $size): void
    {
        $this->sizeProperty->set($size);
    }

    /**
     * @api
     */
    #[MapGetter('position')]
    public function getPosition(): Win32Position
    {
        return $this->positionProperty;
    }

    /**
     * @api
     */
    #[MapSetter('position')]
    public function setPosition(PositionInterface $position): void
    {
        $this->positionProperty->set($position);
    }

    /**
     * @api
     * @return non-empty-string|null
     */
    #[MapGetter('icon')]
    public function getIcon(): ?string
    {
        return $this->currentIcon;
    }

    /**
     * @api
     * @param non-empty-string|null $pathname
     */
    #[MapSetter('icon')]
    public function setIcon(?string $pathname): void
    {
        // @phpstan-ignore-next-line
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
        $this->user32->DestroyWindow($this->handle->ptr);
    }
}
