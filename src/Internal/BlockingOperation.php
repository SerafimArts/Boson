<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal;

/**
 * Marks methods that blocks current execution thread. This can slow down
 * the work and make it impossible to continue.
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
final readonly class BlockingOperation {}
