<?php

declare(strict_types=1);

namespace Local\Property;

/**
 * @template T of mixed
 *
 * @template-implements WritablePropertyInterface<T>
 */
final readonly class WritableProperty implements WritablePropertyInterface
{
    /**
     * @var \Closure(T):mixed
     */
    private \Closure $set;

    /**
     * @param callable(T):mixed $set
     */
    public function __construct(callable $set)
    {
        $this->set = $set(...);
    }

    /**
     * @param T $value
     */
    public function set(mixed $value): void
    {
        ($this->set)($value);
    }
}
