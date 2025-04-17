<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal;

/**
 * Marks any class as being a window event.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class AsWindowEvent {}
