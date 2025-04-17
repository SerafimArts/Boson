<?php

declare(strict_types=1);

namespace Serafim\Boson\Shared\Marker;

/**
 * Marks any class as being a webview event or intention.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class AsWebViewEvent {}
