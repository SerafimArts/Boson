<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Lib;

/**
 * The following are the extended window styles.
 *
 * @link https://learn.microsoft.com/en-us/windows/win32/winmsg/extended-window-styles
 */
final readonly class WindowExtendedStyle
{
    public const int WS_EX_DLGMODALFRAME = 0x0000_0001;
    public const int WS_EX_NOPARENTNOTIFY = 0x0000_0004;
    public const int WS_EX_TOPMOST = 0x0000_0008;
    public const int WS_EX_ACCEPTFILES = 0x0000_0010;
    public const int WS_EX_TRANSPARENT = 0x0000_0020;
    public const int WS_EX_MDICHILD = 0x0000_0040;
    public const int WS_EX_TOOLWINDOW = 0x0000_0080;
    public const int WS_EX_WINDOWEDGE = 0x0000_0100;
    public const int WS_EX_CLIENTEDGE = 0x0000_0200;
    public const int WS_EX_CONTEXTHELP = 0x0000_0400;
    public const int WS_EX_RIGHT = 0x0000_1000;
    public const int WS_EX_LEFT = 0x0000_0000;
    public const int WS_EX_RTLREADING = 0x0000_2000;
    public const int WS_EX_LTRREADING = 0x0000_0000;
    public const int WS_EX_LEFTSCROLLBAR = 0x0000_4000;
    public const int WS_EX_RIGHTSCROLLBAR = 0x0000_0000;
    public const int WS_EX_CONTROLPARENT = 0x0001_0000;
    public const int WS_EX_STATICEDGE = 0x0002_0000;
    public const int WS_EX_APPWINDOW = 0x0004_0000;
    public const int WS_EX_LAYERED = 0x0008_0000;
    public const int WS_EX_NOINHERITLAYOUT = 0x0010_0000;
    public const int WS_EX_NOREDIRECTIONBITMAP = 0x0020_0000;
    public const int WS_EX_LAYOUTRTL = 0x0040_0000;
    public const int WS_EX_COMPOSITED = 0x0200_0000;
    public const int WS_EX_NOACTIVATE = 0x0800_0000;
    public const int WS_EX_OVERLAPPEDWINDOW = self::WS_EX_WINDOWEDGE
        | self::WS_EX_CLIENTEDGE;
    public const int WS_EX_PALETTEWINDOW = self::WS_EX_WINDOWEDGE
        | self::WS_EX_TOOLWINDOW
        | self::WS_EX_TOPMOST;
}
