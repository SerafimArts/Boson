<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Lib;

/**
 * @link https://learn.microsoft.com/en-us/windows/win32/api/winuser/nf-winuser-getsyscolor#parameters
 */
final readonly class Color
{
    public const int COLOR_SCROLLBAR = 0;
    public const int COLOR_BACKGROUND = 1;
    public const int COLOR_ACTIVECAPTION = 2;
    public const int COLOR_INACTIVECAPTION = 3;
    public const int COLOR_MENU = 4;
    public const int COLOR_WINDOW = 5;
    public const int COLOR_WINDOWFRAME = 6;
    public const int COLOR_MENUTEXT = 7;
    public const int COLOR_WINDOWTEXT = 8;
    public const int COLOR_CAPTIONTEXT = 9;
    public const int COLOR_ACTIVEBORDER = 10;
    public const int COLOR_INACTIVEBORDER = 11;
    public const int COLOR_APPWORKSPACE = 12;
    public const int COLOR_HIGHLIGHT = 13;
    public const int COLOR_HIGHLIGHTTEXT = 14;
    public const int COLOR_BTNFACE = 15;
    public const int COLOR_BTNSHADOW = 16;
    public const int COLOR_GRAYTEXT = 17;
    public const int COLOR_BTNTEXT = 18;
    public const int COLOR_INACTIVECAPTIONTEXT = 19;
    public const int COLOR_BTNHIGHLIGHT = 20;
    public const int COLOR_3DDKSHADOW = 21;
    public const int COLOR_3DLIGHT = 22;
    public const int COLOR_INFOTEXT = 23;
    public const int COLOR_INFOBK = 24;
    public const int COLOR_HOTLIGHT = 26;
    public const int COLOR_GRADIENTACTIVECAPTION = 27;
    public const int COLOR_GRADIENTINACTIVECAPTION = 28;
    public const int COLOR_MENUHILIGHT = 29;
    public const int COLOR_MENUBAR = 30;
    public const int COLOR_DESKTOP = self::COLOR_BACKGROUND;
    public const int COLOR_3DFACE = self::COLOR_BTNFACE;
    public const int COLOR_3DSHADOW = self::COLOR_BTNSHADOW;
    public const int COLOR_3DHIGHLIGHT = self::COLOR_BTNHIGHLIGHT;
    public const int COLOR_3DHILIGHT = self::COLOR_BTNHIGHLIGHT;
    public const int COLOR_BTNHILIGHT = self::COLOR_BTNHIGHLIGHT;
}
