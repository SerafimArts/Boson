<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

use Serafim\Boson\WebView\WebViewCreateInfo;

/**
 * Information (configuration) for creating a new physical window
 */
final readonly class WindowCreateInfo
{
    /**
     * Gets default window width.
     */
    public const int DEFAULT_WIDTH = 640;

    /**
     * Gets default window height.
     */
    public const int DEFAULT_HEIGHT = 480;

    public function __construct(
        /**
         * Sets initial window title.
         */
        public string $title = '',
        /**
         * Sets initial window width.
         *
         * @var int<0, 2147483647>
         */
        public int $width = self::DEFAULT_WIDTH,
        /**
         * Sets initial window height.
         *
         * @var int<0, 2147483647>
         */
        public int $height = self::DEFAULT_HEIGHT,
        /**
         * Enable window dark mode in case of {@see true} or disable
         * in case of {@see false}.
         *
         * In case of {@see null} the theme will be identical to the system one.
         */
        public ?bool $darkMode = null,
        /**
         * Enables graphics hardware acceleration in case of this option
         * is set to {@see true} or disables in case {@see false}.
         *
         * Note: [MACOS] WKWebView does not allow to control
         *       hardware-acceleration.
         */
        public bool $enableHardwareAcceleration = true,
        /**
         * Displays a window when the application starts.
         */
        public bool $visible = true,
        /**
         * Allows the user to resize the window.
         */
        public bool $resizable = true,
        /**
         * Information (configuration) about creating a new webview object
         * that will be attached to the window.
         */
        public WebViewCreateInfo $webview = new WebViewCreateInfo(),
    ) {
        // @phpstan-ignore-next-line : DbC invariant
        assert($width >= 0, new \InvalidArgumentException(
            message: 'Window width cannot be less than 0',
        ));

        // @phpstan-ignore-next-line : DbC invariant
        assert($height >= 0, new \InvalidArgumentException(
            message: 'Window height cannot be less than 0',
        ));
    }
}
