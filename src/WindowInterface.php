<?php

declare(strict_types=1);

namespace Serafim\Boson;

use Serafim\Boson\Window\HandleInterface;
use Serafim\Boson\Window\PositionInterface;
use Serafim\Boson\Window\SizeInterface;
use Serafim\Boson\Window\WebViewInterface;

/**
 * A class abstraction for a high DPI-aware Window.
 * Intended to be inherited from by classes that wish to specialize with custom
 * rendering and input handling.
 *
 * @property string $title The title of the specified window encoded as UTF-8,
 *           of the specified window.
 * @property non-empty-string|null $icon The icon pathname for the specified
 *           window. If no icon pathname are specified, the window contains
 *           default icon.
 * @property SizeInterface $size The size of the content area of the specified
 *           window.
 * @property PositionInterface $position The position of the content area of
 *           the specified window.
 * @property-read HandleInterface $handle Returns the backing Window handle to
 *                enable clients to set icon and other window properties.
 *                Returns {@see null} if the window has been destroyed.
 * @property-read WebViewInterface $webview Contains the WebView instance for
 *                the specified window.
 */
interface WindowInterface
{
    /**
     * Makes the specified window visible.
     *
     * This function makes the specified window visible if it was previously
     * hidden. If the window is already visible or is in full screen mode,
     * this function does nothing.
     */
    public function show(): void;

    /**
     * Hides the specified window.
     *
     * This function hides the specified window if it was previously visible.
     * If the window is already hidden or is in full screen mode, this function
     * does nothing.
     */
    public function hide(): void;

    /**
     * Destroys the specified window and its context.
     */
    public function close(): void;
}
