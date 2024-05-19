<?php

declare(strict_types=1);

namespace Local\Property\Attribute;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
readonly class MapProperty
{
    /**
     * @param non-empty-string|null $name
     */
    public function __construct(
        public ?string $name = null,
        public Access $access = Access::BOTH,
    ) {}
}
