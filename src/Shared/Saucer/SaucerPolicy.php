<?php

declare(strict_types=1);

namespace Serafim\Boson\Shared\Saucer;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson
 */
final readonly class SaucerPolicy
{
    public const int SAUCER_POLICY_ALLOW = 0;
    public const int SAUCER_POLICY_BLOCK = 1;

    private function __construct() {}
}
