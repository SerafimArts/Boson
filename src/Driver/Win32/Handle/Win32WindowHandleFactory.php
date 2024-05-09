<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Handle;

use Serafim\WinUI\CreateInfo;
use Serafim\WinUI\Driver\Win32\Lib\User32;
use Serafim\WinUI\Driver\Win32\Lib\WindowExtendedStyle;
use Serafim\WinUI\Driver\Win32\Lib\WindowStyle;
use Serafim\WinUI\Driver\Win32\Text;
use Serafim\WinUI\Driver\Win32\Text\Converter;
use Serafim\WinUI\Driver\Win32\Win32Position;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\WinUI\Driver\Win32
 */
final class Win32WindowHandleFactory
{
    /**
     * @var int-mask-of<WindowExtendedStyle::WS_EX_*>
     */
    private const int DEFAULT_EX_WINDOW_STYLE = WindowExtendedStyle::WS_EX_TOPMOST
        | WindowExtendedStyle::WS_EX_LTRREADING;

    /**
     * @var int-mask-of<WindowStyle::WS_*>
     */
    private const int DEFAULT_WINDOW_STYLE = WindowStyle::WS_CAPTION
        | WindowStyle::WS_OVERLAPPEDWINDOW
        | WindowStyle::WS_SYSMENU;

    private readonly User32 $user32;

    private readonly Converter $text;

    public function __construct(
        ?User32 $user32 = null,
        ?Converter $text = null,
    ) {
        $this->user32 = $user32 ?? User32::getInstance();
        $this->text = $text ?? Text::getInstance();
    }

    public function create(Win32ClassHandle $class, CreateInfo $info): Win32WindowHandle
    {
        return new Win32WindowHandle(
            class: $class,
            ptr: $this->user32->CreateWindowExW(
                /* DWORD     dwExStyle */
                self::DEFAULT_EX_WINDOW_STYLE,
                /* LPCSTR    lpClassName */
                $this->text->wide($class->id, owned: false),
                /* LPCSTR    lpWindowName */
                $this->text->wide($info->title, owned: false),
                /* DWORD     dwStyle */
                self::DEFAULT_WINDOW_STYLE,
                /* int       X */
                Win32Position::CW_USER_DEFAULT,
                /* int       Y */
                Win32Position::CW_USER_DEFAULT,
                /* int       nWidth */
                $info->width,
                /* int       nHeight */
                $info->height,
                /* HWND      hWndParent */
                null,
                /* HMENU     hMenu */
                null,
                /* HINSTANCE hInstance */
                $class->instance->ptr,
                /* LPVOID    lpPara */
                null
            ),
        );
    }
}
