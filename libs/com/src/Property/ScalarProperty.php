<?php

declare(strict_types=1);

namespace Local\Com\Property;

use FFI\CData;
use Local\Com\Struct;
use Local\Property\PropertyInterface;

/**
 * @template TRead of scalar
 * @template TWrite of scalar
 * @template-implements PropertyInterface<TRead, TWrite>
 */
readonly class ScalarProperty implements PropertyInterface
{
    /**
     * @var Property<CData, TWrite|CData>
     */
    private Property $property;

    /**
     * @param Struct<object> $context Same as {@see Property::$context}.
     * @param non-empty-string $name Same as {@see Property::$name}.
     * @param non-empty-string $type Same as {@see Property::$type}.
     */
    public function __construct(Struct $context, string $name, string $type)
    {
        $this->property = new Property($context, $name, $type);
    }

    public function get(): mixed
    {
        $cdata = $this->property->get();

        return $cdata->cdata;
    }

    public function set(mixed $value): void
    {
        $this->property->set($value);
    }
}
