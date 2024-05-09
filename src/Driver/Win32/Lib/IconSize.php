<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Lib;

/**
 * @link https://docs.microsoft.com/en-us/windows/win32/winmsg/wm-seticon
 */
final readonly class IconSize
{
    public const int ICON_SMALL  = 0x00;
    public const int ICON_BIG    = 0x01;
    public const int ICON_SMALL2 = 0x02;
}
