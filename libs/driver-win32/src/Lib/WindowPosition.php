<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Lib;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Local\Driver\Win32\Win32
 */
final readonly class WindowPosition
{
    public const int SWP_NOSIZE = 0x0001;
    public const int SWP_NOMOVE = 0x0002;
    public const int SWP_NOZORDER = 0x0004;
    public const int SWP_NOREDRAW = 0x0008;
    public const int SWP_NOACTIVATE = 0x0010;
    public const int SWP_FRAMECHANGED = 0x0020;
    public const int SWP_SHOWWINDOW = 0x0040;
    public const int SWP_HIDEWINDOW = 0x0080;
    public const int SWP_NOCOPYBITS = 0x0100;
    public const int SWP_NOOWNERZORDER = 0x0200;
    public const int SWP_NOSENDCHANGING = 0x0400;
    public const int SWP_DRAWFRAME = self::SWP_FRAMECHANGED;
    public const int SWP_NOREPOSITION = self::SWP_NOOWNERZORDER;
    public const int SWP_DEFERERASE = 0x2000;
    public const int SWP_ASYNCWINDOWPOS = 0x4000;
}
