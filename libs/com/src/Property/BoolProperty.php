<?php

declare(strict_types=1);

namespace Local\Com\Property;

use Local\Com\Struct;

/**
 * @template-extends ScalarProperty<bool, bool|int>
 */
final readonly class BoolProperty extends ScalarProperty
{
    /**
     * @var non-empty-string
     */
    private const string DEFAULT_TYPE = 'BOOL';

    /**
     * @param Struct<object> $context Same as {@see Property::$context}.
     * @param non-empty-string $name Same as {@see Property::$name}.
     * @param non-empty-string $type Same as {@see Property::$type}.
     */
    public function __construct(Struct $context, string $name, string $type = self::DEFAULT_TYPE)
    {
        parent::__construct($context, $name, $type);
    }

    public function get(): bool
    {
        return (bool) parent::get();
    }

    public function set(mixed $value): void
    {
        parent::set((bool) $value);
    }
}
