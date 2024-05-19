<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Handle;

use Local\Com\WideString;
use Serafim\WinUI\CreateInfo;
use Local\Driver\Win32\Lib\User32;
use Local\Driver\Win32\Lib\WindowExtendedStyle;
use Local\Driver\Win32\Lib\WindowStyle;
use Local\Driver\Win32\Win32\Win32Position;

/**
 * @internal this is an internal library class, please do not use it in your code
 */
final class Win32WindowHandleFactory
{
    /**
     * @var int-mask-of<WindowExtendedStyle::WS_EX_*>
     */
    private const int DEFAULT_EX_WINDOW_STYLE = WindowExtendedStyle::WS_EX_LTRREADING
        | WindowExtendedStyle::WS_EX_LEFT
        | WindowExtendedStyle::WS_EX_RIGHTSCROLLBAR
        | WindowExtendedStyle::WS_EX_APPWINDOW;

    /**
     * @var int-mask-of<WindowStyle::WS_*>
     */
    private const int DEFAULT_WINDOW_STYLE = WindowStyle::WS_OVERLAPPEDWINDOW
        | WindowStyle::WS_CLIPSIBLINGS
        | WindowStyle::WS_CLIPCHILDREN
        | WindowStyle::WS_POPUP;

    public function __construct(
        private readonly User32 $user32,
    ) {}

    public function create(CreateInfo $info, Win32ClassHandle $class): Win32WindowHandle
    {
        $style = self::DEFAULT_WINDOW_STYLE;

        if ($info->resizable === false) {
            $style &= ~WindowStyle::WS_MINIMIZEBOX;
            $style &= ~WindowStyle::WS_MAXIMIZEBOX;
            $style &= ~WindowStyle::WS_THICKFRAME;
        }

        return new Win32WindowHandle(
            class: $class,
            ptr: $this->user32->CreateWindowExW(
                /* DWORD     dwExStyle */
                self::DEFAULT_EX_WINDOW_STYLE,
                /* LPCSTR    lpClassName */
                WideString::toWideStringCData($this->user32, $class->id),
                /* LPCSTR    lpWindowName */
                WideString::toWideStringCData($this->user32, $info->title),
                /* DWORD     dwStyle */
                $style,
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
