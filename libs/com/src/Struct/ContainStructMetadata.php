<?php

declare(strict_types=1);

namespace Local\Com\Struct;

use Local\Com\Meta\AttributeReader;
use Local\Com\Meta\InMemoryReader;
use Local\Com\Meta\ReaderInterface;
use Local\Com\Meta\StructMetadata;

trait ContainStructMetadata
{
    private static ?ReaderInterface $struct = null;

    protected static function getStructMetadata(): StructMetadata
    {
        self::$struct ??= new InMemoryReader(
            delegate: new AttributeReader(),
        );

        return self::$struct->read(static::class);
    }
}
