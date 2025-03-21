<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\DesktopWindowManager;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson\Core\DesktopWindowManager
 */
final readonly class DWMWindowAttribute
{
    /**
     * [get] Is non-client rendering enabled/disabled
     */
    public const int DWMWA_NCRENDERING_ENABLED = 1;

    /**
     * [set] DWMNCRENDERINGPOLICY - Non-client rendering policy
     */
    public const int DWMWA_NCRENDERING_POLICY = 2;

    /**
     * [set] Potentially enable/forcibly disable transitions
     */
    public const int DWMWA_TRANSITIONS_FORCEDISABLED = 3;

    /**
     * [set] Allow contents rendered in the non-client area to be visible on
     * the DWM-drawn frame.
     */
    public const int DWMWA_ALLOW_NCPAINT = 4;

    /**
     * [get] Bounds of the caption button area in window-relative space.
     */
    public const int DWMWA_CAPTION_BUTTON_BOUNDS = 5;

    /**
     * [set] Is non-client content RTL mirrored
     */
    public const int DWMWA_NONCLIENT_RTL_LAYOUT = 6;

    /**
     * [set] Force this window to display iconic thumbnails.
     */
    public const int DWMWA_FORCE_ICONIC_REPRESENTATION = 7;

    /**
     * [set] Designates how Flip3D will treat the window.
     */
    public const int DWMWA_FLIP3D_POLICY = 8;

    /**
     * [get] Gets the extended frame bounds rectangle in screen space
     */
    public const int DWMWA_EXTENDED_FRAME_BOUNDS = 9;

    /**
     * [set] Indicates an available bitmap when there is no better thumbnail
     * representation.
     */
    public const int DWMWA_HAS_ICONIC_BITMAP = 10;

    /**
     * [set] Don't invoke Peek on the window.
     */
    public const int DWMWA_DISALLOW_PEEK = 11;

    /**
     * [set] LivePreview exclusion information
     */
    public const int DWMWA_EXCLUDED_FROM_PEEK = 12;

    /**
     * [set] Cloak or uncloak the window
     */
    public const int DWMWA_CLOAK = 13;

    /**
     * [get] Gets the cloaked state of the window
     */
    public const int DWMWA_CLOAKED = 14;

    /**
     * [set] BOOL, Force this window to freeze the thumbnail without live update
     */
    public const int DWMWA_FREEZE_REPRESENTATION = 15;

    /**
     * [set] BOOL, Updates the window only when desktop composition runs for
     * other reasons
     */
    public const int DWMWA_PASSIVE_UPDATE_MODE = 16;

    /**
     * [set] BOOL, Allows the use of host backdrop brushes for the window.
     */
    public const int DWMWA_USE_HOSTBACKDROPBRUSH = 17;

    /**
     * Undocumented in Windows 10 SDK
     *
     * Value was 19 pre Windows 10 20H1 Update
     *
     * @link https://stackoverflow.com/questions/39261826/change-the-color-of-the-title-bar-caption-of-a-win32-application/70693198#70693198
     */
    public const int DWMWA_USE_IMMERSIVE_DARK_MODE_PRE_20H1 = 19;

    /**
     * [set] BOOL, Allows a window to either use the accent color, or dark,
     * according to the user Color Mode preferences.
     */
    public const int DWMWA_USE_IMMERSIVE_DARK_MODE = 20;

    /**
     * [set] WINDOW_CORNER_PREFERENCE, Controls the policy
     * that rounds top-level window corners
     */
    public const int DWMWA_WINDOW_CORNER_PREFERENCE = 33;

    /**
     * [set] COLORREF, The color of the thin border around a top-level window
     */
    public const int DWMWA_BORDER_COLOR = 34;

    /**
     * [set] COLORREF, The color of the caption
     */
    public const int DWMWA_CAPTION_COLOR = 35;

    /**
     * [set] COLORREF, The color of the caption text
     */
    public const int DWMWA_TEXT_COLOR = 36;

    /**
     * [get] UINT, width of the visible border around a thick frame window
     */
    public const int DWMWA_VISIBLE_FRAME_BORDER_THICKNESS = 37;

    /**
     * [get, set] SYSTEMBACKDROP_TYPE, Controls the system-drawn backdrop
     * material of a window, including behind the non-client area.
     */
    public const int DWMWA_SYSTEMBACKDROP_TYPE = 38;

    public const int DWMWA_LAST = 39;

    private function __construct() {}
}
