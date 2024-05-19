<?php

declare(strict_types=1);

namespace Local\Com\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class MapStruct
{
    /**
     * @param non-empty-string|null $name
     */
    public function __construct(
        public ?string $name = null,
        public bool $owned = true,
    ) {}
}
