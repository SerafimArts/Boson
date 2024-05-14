<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Lib;

/**
 * The following are the window styles. After the window has been created,
 * these styles cannot be modified, except as noted.
 *
 * @link https://docs.microsoft.com/en-us/windows/win32/winmsg/window-styles
 */
final readonly class WindowStyle
{
    public const int WS_OVERLAPPED = 0x0000_0000;
    public const int WS_POPUP = 0x8000_0000;

    /**
     * The window is a child window. A window with this style cannot have a
     * menu bar. This style cannot be used with the WS_POPUP style.
     */
    public const int WS_CHILD = 0x4000_0000;
    public const int WS_MINIMIZE = 0x2000_0000;
    public const int WS_VISIBLE = 0x1000_0000;

    /**
     * The window is initially disabled. A disabled window cannot receive input
     * from the user. To change this after a window has been created, use the
     * EnableWindow function.
     */
    public const int WS_DISABLED = 0x0800_0000;

    /**
     * Clips child windows relative to each other; that is, when a particular
     * child window receives a WM_PAINT message, the WS_CLIPSIBLINGS style
     * clips all other overlapping child windows out of the region of the child
     * window to be updated. If WS_CLIPSIBLINGS is not specified and child
     * windows overlap, it is possible, when drawing within the client area
     * of a child window, to draw within the client area of a neighboring
     * child window.
     */
    public const int WS_CLIPSIBLINGS = 0x0400_0000;

    /**
     * Excludes the area occupied by child windows when drawing occurs within
     * the parent window. This style is used when creating the parent window.
     */
    public const int WS_CLIPCHILDREN = 0x0200_0000;
    public const int WS_MAXIMIZE = 0x0100_0000;

    /**
     * The window has a title bar (includes the WS_BORDER style).
     */
    public const int WS_CAPTION = 0x00C0_0000;

    /**
     * The window has a thin-line border
     */
    public const int WS_BORDER = 0x0080_0000;

    /**
     * The window has a border of a style typically used with dialog boxes.
     * A window with this style cannot have a title bar.
     */
    public const int WS_DLGFRAME = 0x0040_0000;
    public const int WS_VSCROLL = 0x0020_0000;
    public const int WS_HSCROLL = 0x0010_0000;
    public const int WS_SYSMENU = 0x0008_0000;
    public const int WS_THICKFRAME = 0x0004_0000;

    /**
     * The window is the first control of a group of controls. The group
     * consists of this first control and all controls defined after it, up to
     * the next control with the WS_GROUP style. The first control in each group
     * usually has the WS_TABSTOP style so that the user can move from group to
     * group. The user can subsequently change the keyboard focus from one
     * control in the group to the next control in the group by using the
     * direction keys.
     *
     * You can turn this style on and off to change dialog box navigation.
     * To change this style after a window has been created, use the
     * SetWindowLong function.
     */
    public const int WS_GROUP = 0x0002_0000;
    public const int WS_TABSTOP = 0x0001_0000;
    public const int WS_MINIMIZEBOX = 0x0002_0000;
    public const int WS_MAXIMIZEBOX = 0x0001_0000;
    public const int WS_TILED = self::WS_OVERLAPPED;
    public const int WS_ICONIC = self::WS_MINIMIZE;
    public const int WS_SIZEBOX = self::WS_THICKFRAME;
    public const int WS_TILEDWINDOW = self::WS_OVERLAPPEDWINDOW;
    public const int WS_POPUPWINDOW = self::WS_POPUP
        | self::WS_BORDER
        | self::WS_SYSMENU;

    /**
     * Same as the WS_CHILD style.
     */
    public const int WS_CHILDWINDOW = self::WS_CHILD;
    public const int WS_OVERLAPPEDWINDOW = self::WS_OVERLAPPED
        | self::WS_CAPTION
        | self::WS_SYSMENU
        | self::WS_THICKFRAME
        | self::WS_MINIMIZEBOX
        | self::WS_MAXIMIZEBOX;
}
