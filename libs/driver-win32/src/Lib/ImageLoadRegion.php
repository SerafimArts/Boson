<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Lib;

/**
 * @link https://docs.microsoft.com/en-us/windows/win32/api/winuser/nf-winuser-loadimagew
 */
final readonly class ImageLoadRegion
{
    public const int LR_DEFAULTCOLOR = 0x0000_0000;
    public const int LR_MONOCHROME = 0x0000_0001;
    public const int LR_COLOR = 0x0000_0002;
    public const int LR_COPYRETURNORG = 0x0000_0004;
    public const int LR_COPYDELETEORG = 0x0000_0008;
    public const int LR_LOADFROMFILE = 0x0000_0010;
    public const int LR_LOADTRANSPARENT = 0x0000_0020;
    public const int LR_DEFAULTSIZE = 0x0000_0040;
    public const int LR_VGACOLOR = 0x0000_0080;
    public const int LR_LOADMAP3DCOLORS = 0x0000_1000;
    public const int LR_CREATEDIBSECTION = 0x0000_2000;
    public const int LR_COPYFROMRESOURCE = 0x0000_4000;
    public const int LR_SHARED = 0x0000_8000;
}
