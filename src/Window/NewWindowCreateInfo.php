<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

use Serafim\Boson\WebView\WebViewCreateInfo;

/**
 * Information (configuration) about creating a new window object.
 */
final readonly class NewWindowCreateInfo extends WindowCreateInfo
{
    /**
     * Gets default window width
     */
    public const int DEFAULT_WIDTH = 640;

    /**
     * Gets default window height
     */
    public const int DEFAULT_HEIGHT = 480;

    public function __construct(
        /**
         * Contains the title set for the webview window when created
         */
        public string $title = '',
        /**
         * Sets default window width
         *
         * @var int<0, 2147483647>
         */
        public int $width = self::DEFAULT_WIDTH,
        /**
         * Sets default window height
         *
         * @var int<0, 2147483647>
         */
        public int $height = self::DEFAULT_HEIGHT,
        WebViewCreateInfo $webview = new WebViewCreateInfo(),
    ) {
        // @phpstan-ignore-next-line : DbC invariant
        assert($width >= 0, new \InvalidArgumentException(
            message: 'Window width cannot be less than 0',
        ));

        // @phpstan-ignore-next-line : DbC invariant
        assert($height >= 0, new \InvalidArgumentException(
            message: 'Window height cannot be less than 0',
        ));

        parent::__construct($webview);
    }
}
