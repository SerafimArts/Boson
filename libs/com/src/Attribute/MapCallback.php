<?php

declare(strict_types=1);

namespace Local\Com\Attribute;

#[\Attribute(\Attribute::TARGET_METHOD)]
final readonly class MapCallback
{
    /**
     * @param non-empty-string|null $name
     */
    public function __construct(
        public ?string $name = null,
    ) {}
}
