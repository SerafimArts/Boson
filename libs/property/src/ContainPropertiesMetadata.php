<?php

declare(strict_types=1);

namespace Local\Property;

use Local\Property\Meta\AttributeReader;
use Local\Property\Meta\InMemoryReader;
use Local\Property\Meta\PropertyMetadata;
use Local\Property\Meta\ReaderInterface;

trait ContainPropertiesMetadata
{
    private static ?ReaderInterface $properties = null;

    /**
     * @return list<PropertyMetadata>
     */
    private static function getPropertiesMetadata(): array
    {
        self::$properties ??= new InMemoryReader(
            delegate: new AttributeReader(),
        );

        return self::$properties->read(static::class);
    }
}
