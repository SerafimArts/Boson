<?php

declare(strict_types=1);

namespace Local\Id;

/**
 * @template-implements IdInterface<int>
 */
final readonly class IntIdentifier implements IdInterface
{
    public function __construct(
        private int $value,
    ) {}

    public function toPrimitive(): int
    {
        return $this->value;
    }

    public function equals(IdInterface $id): bool
    {
        // - In case of passed argument is a same object
        return $id === $this
            // - Or same instance with same value
            || ($id instanceof self && $this->value === $id->value)
            // - Or different instances contains equal values
            || (string) $this->value === (string) $id;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
