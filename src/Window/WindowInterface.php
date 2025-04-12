<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

use Serafim\Boson\Application;
use Serafim\Boson\Vfs\VirtualFileSystemInterface;
use Serafim\Boson\WebView\WebView;
use Serafim\Boson\Window\Size\Size;
use Serafim\Boson\Window\Size\SizeInterface;
use Serafim\Boson\Window\Size\MutableSizeInterface;

interface WindowInterface
{
    /**
     * Contains an identifier of the window.
     *
     * @readonly
     */
    public WindowId $id {
        /**
         * Gets window identifier.
         */
        get;
    }

    /**
     * An information DTO about the window with which it was created.
     *
     * @readonly
     */
    public WindowCreateInfo $info {
        /**
         * Gets window creation info.
         */
        get;
    }

    /**
     * An application to which this window belongs.
     *
     * @readonly
     */
    public Application $app {
        /**
         * Gets window's application instance.
         */
        get;
    }

    /**
     * Contains virtual filesystem attached to the Window and WebView.
     *
     * @readonly
     */
    public VirtualFileSystemInterface $fs {
        /**
         * Gets the VFS.
         */
        get;
    }

    /**
     * Contains {@see WebView} instance attached to the window.
     *
     * @readonly
     */
    public WebView $webview {
        /**
         * Gets {@see WebView} instance attached to the current window.
         */
        get;
    }

    /**
     * The title of the specified window encoded as UTF-8.
     */
    public string $title {
        /**
         * Gets window title value.
         */
        get;
        /**
         * Allows to update window title value.
         */
        set;
    }

    /**
     * Contains current window size.
     */
    public MutableSizeInterface $size {
        /**
         * Returns mutable {@see MutableSizeInterface} window size value object.
         *
         * ```
         * echo $window->size; // Size(640 × 480)
         * ```
         *
         * Since the property returns mutable window size, they can be
         * changed explicitly.
         *
         * ```
         * $window->size->width = 640;
         * $window->size->height = 648;
         * ```
         *
         * Or using simultaneously update.
         *
         * ```
         * $window->size->update(640, 480);
         * ```
         */
        get;
        /**
         * Allows to update window size using any {@see SizeInterface}
         * (for example {@see Size}) instance.
         *
         * ```
         * $window->min = new Size(640, 480);
         * ```
         *
         * The sizes can also be passed between different window instances
         * and window properties.
         *
         * ```
         * $window1->size = $window2->size;
         * ```
         */
        set(SizeInterface $size);
    }

    /**
     * Contains minimum size bounds of the window.
     */
    public MutableSizeInterface $min {
        /**
         * Returns mutable {@see MutableSizeInterface} minimum size bounds
         * of the window.
         *
         * ```
         * echo $window->min; // Size(0 × 0)
         * ```
         *
         * Since the property returns mutable minimum size bounds,
         * they can be changed explicitly.
         *
         * ```
         * $window->min->width = 640;
         * $window->min->height = 648;
         * ```
         *
         * Or using simultaneously update.
         *
         * ```
         * $window->min->update(640, 480);
         * ```
         */
        get;
        /**
         * Allows to update window minimal size bound using any
         * {@see SizeInterface} (for example {@see Size}) instance.
         *
         * ```
         * $window->min = new Size(640, 480);
         * ```
         *
         * The sizes can also be passed between different window instances
         * and window properties.
         *
         * ```
         * $window->min = $window->size;
         * ```
         */
        set(SizeInterface $size);
    }

    /**
     * Contains maximum size bounds of the window.
     */
    public MutableSizeInterface $max {
        /**
         * Returns mutable {@see MutableSizeInterface} maximum size bounds
         * of the window.
         *
         * ```
         * echo $window->max; // Size(5142 × 1462)
         * ```
         *
         * Since the property returns mutable maximum size bounds,
         * they can be changed explicitly.
         *
         * ```
         * $window->max->width = 640;
         * $window->max->height = 648;
         * ```
         *
         * Or using simultaneously update.
         *
         * ```
         * $window->max->update(640, 480);
         * ```
         */
        get;
        /**
         * Allows to update window maximal size bound using any
         * {@see SizeInterface} (for example {@see Size}) instance.
         *
         * ```
         * $window->max = new Size(640, 480);
         * ```
         *
         * The sizes can also be passed between different window instances
         * and window properties.
         *
         * ```
         * $window->max = $window->size;
         * ```
         */
        set(SizeInterface $size);
    }

    /**
     * Contains window dark mode option.
     *
     * In case of {@see true} then the dark mode is forcibly enabled,
     * or {@see false} instead.
     */
    public bool $isDarkModeEnabled {
        /**
         * Gets current window dark mode.
         *
         * ```
         * if ($window->isDarkModeEnabled) {
         *     echo 'Dark mode is enabled';
         * } else {
         *     echo 'Dark mode is disabled';
         * }
         * ```
         */
        get;
        /**
         * Updates current window dark mode.
         *
         * ```
         * $window->isDarkModeEnabled = true;
         * ```
         */
        set;
    }

    /**
     * Contains window visibility option.
     */
    public bool $isVisible {
        /**
         * Gets current window visibility state.
         */
        get;
        /**
         * Show the window in case of property will be set to {@see true}
         * or hide in case of {@see false}.
         */
        set;
    }

    /**
     * Makes this window visible.
     *
     * Note: The same can be done using the window's visibility
     *       property `$window->isVisible = true`.
     */
    public function show(): void;

    /**
     * Hides this window.
     *
     * Note: The same can be done using the window's visibility
     *       property `$window->isVisible = false`.
     */
    public function hide(): void;

    /**
     * Closes and destroys this window and its context.
     */
    public function close(): void;
}
