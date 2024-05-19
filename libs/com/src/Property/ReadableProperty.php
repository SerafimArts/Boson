<?php

declare(strict_types=1);

namespace Local\Com\Property;

use FFI\CData;
use Local\Com\Struct;
use Local\Property\ReadablePropertyInterface;

/**
 * @template T of CData
 * @template-implements ReadablePropertyInterface<T>
 */
final readonly class ReadableProperty implements ReadablePropertyInterface
{
    /**
     * @var Property<T, T>
     */
    private Property $property;

    /**
     * @param Struct<object> $context Same as {@see Property::$context}.
     * @param non-empty-string $name Same as {@see Property::$name}.
     * @param non-empty-string $type Same as {@see Property::$type}.
     * @param bool $once Whether the property should be obtained only once. In
     *        the future, the data will be memoized inside the specified
     *        property instance.
     */
    public function __construct(
        Struct $context,
        string $name,
        string $type,
        private bool $once = true,
    ) {
        $this->property = new Property($context, $name, $type);
    }

    public function get(): CData
    {
        if ($this->once && $this->property->isInitialized()) {
            return $this->property->value;
        }

        return $this->property->get();
    }
}
