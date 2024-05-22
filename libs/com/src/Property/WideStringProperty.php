<?php

declare(strict_types=1);

namespace Local\Com\Property;

use FFI\CData;
use Local\Com\Struct;
use Local\Com\WideString;
use Local\Property\PropertyInterface;

/**
 * @template-implements PropertyInterface<string, string>
 */
final readonly class WideStringProperty implements PropertyInterface
{
    /**
     * @var non-empty-string
     */
    private const string DEFAULT_TYPE = 'LPWSTR';

    /**
     * @var Property<CData, CData|string>
     */
    private Property $property;

    /**
     * @param Struct<object> $context Same as {@see Property::$context}.
     * @param non-empty-string $name Same as {@see Property::$name}.
     * @param non-empty-string $type Same as {@see Property::$type}.
     */
    public function __construct(
        Struct $context,
        string $name,
        string $type = self::DEFAULT_TYPE,
    ) {
        $this->property = new Property($context, $name, $type);
    }

    public function get(): string
    {
        return WideString::fromWideString($this->property->get());
    }

    public function set(mixed $value): void
    {
        $this->property->set(WideString::toWideString($value));
    }
}
