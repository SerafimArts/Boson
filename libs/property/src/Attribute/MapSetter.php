<?php

declare(strict_types=1);

namespace Local\Property\Attribute;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
final readonly class MapSetter extends MapProperty
{
    /**
     * @param non-empty-string|null $name
     */
    public function __construct(?string $name = null)
    {
        parent::__construct($name, Access::WRITE);
    }
}
