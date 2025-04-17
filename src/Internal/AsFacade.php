<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal;

/**
 * Marks any method or property as a facade to simplify access to a subsystem
 * that does not implement the behavior directly, but delegates it to
 * a third-party service responsible for it.
 */
#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY)]
readonly class AsFacade
{
    public function __construct(
        /**
         * Class responsible for implementation.
         *
         * @var class-string
         */
        public string $of,
    ) {}
}
