<?php

declare(strict_types=1);

namespace Serafim\Boson\Shared;

/**
 * Marks methods that return pointers that REQUIRE manual deallocation.
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
final readonly class RequiresDealloc {}
