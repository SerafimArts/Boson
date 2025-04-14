<?php

declare(strict_types=1);

namespace Serafim\Boson\Kernel;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson
 */
final readonly class SaucerLoadTime
{
    public const int SAUCER_LOAD_TIME_CREATION = 0;
    public const int SAUCER_LOAD_TIME_READY = 1;

    private function __construct() {}
}
