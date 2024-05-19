<?php

declare(strict_types=1);

namespace Local\Com\Property;

use Local\Com\Struct;

/**
 * @template-extends ScalarProperty<float, float|int>
 */
final readonly class DoubleProperty extends ScalarProperty
{
    /**
     * @var non-empty-string
     */
    private const string DEFAULT_TYPE = 'double';

    /**
     * @param Struct<object> $context Same as {@see Property::$context}.
     * @param non-empty-string $name Same as {@see Property::$name}.
     * @param non-empty-string $type Same as {@see Property::$type}.
     */
    public function __construct(Struct $context, string $name, string $type = self::DEFAULT_TYPE)
    {
        parent::__construct($context, $name, $type);
    }

    public function get(): float
    {
        // @phpstan-ignore-next-line
        return (float) parent::get();
    }

    public function set(mixed $value): void
    {
        parent::set((float) $value);
    }
}
