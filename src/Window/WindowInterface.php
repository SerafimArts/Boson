<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

use Serafim\Boson\WebView\WebView;

interface WindowInterface
{
    /**
     * An information DTO about the window with which it was created.
     *
     * @readonly
     */
    public WindowCreateInfo $info { get; }

    /**
     * Gets driver-specific window handle instance.
     *
     * @readonly
     */
    public HandleInterface $handle { get; }

    /**
     * Gets WebView instance attached to the current window
     *
     * @readonly
     */
    public WebView $webview { get; }

    /**
     * The title of the specified window encoded as UTF-8.
     */
    public string $title { get; set; }

    /**
     * Updates the size of the native window
     *
     * Note:
     *  - Using {@see WindowSizeHint::MaxBounds} for setting the maximum window
     *    size is not supported with GTK 4 (Linux platform) because X11-specific
     *    functions such as `gtk_window_set_geometry_hints` were removed.
     *    This option has no effect when using GTK 4.
     *
     * @param int<0, 2147483647> $width
     * @param int<0, 2147483647> $height
     */
    public function resize(int $width, int $height, WindowSizeHint $hint = WindowSizeHint::Default): void;

    /**
     * Closes expected window
     */
    public function close(): void;
}
