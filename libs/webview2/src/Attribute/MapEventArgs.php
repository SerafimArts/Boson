<?php

declare(strict_types=1);

namespace Local\WebView2\Attribute;

use Local\WebView2\Handler\EventArgs;

#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class MapEventArgs
{
    /**
     * @param class-string<EventArgs> $class
     */
    public function __construct(
        public string $class,
    ) {}
}
