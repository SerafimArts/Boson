<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal;

/**
 * Marks methods that return pointers that REQUIRE manual deallocation.
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
final readonly class RequiresDealloc {}
