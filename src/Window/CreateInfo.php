<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

/**
 * DTO containing the initial information for creating the window.
 */
final readonly class CreateInfo
{
    /**
     * @var int<0, max>
     */
    public const int DEFAULT_WIDTH = 640;

    /**
     * @var int<0, max>
     */
    public const int DEFAULT_HEIGHT = 480;

    /**
     * @param int<0, max> $width
     * @param int<0, max> $height
     */
    public function __construct(
        public string $title = '',
        public int $width = self::DEFAULT_WIDTH,
        public int $height = self::DEFAULT_HEIGHT,
        public bool $resizable = false,
        public bool $visible = true,
        public bool $debug = false,
    ) {}
}
