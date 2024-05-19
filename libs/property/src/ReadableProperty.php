<?php

declare(strict_types=1);

namespace Local\Property;

/**
 * @template T of mixed
 *
 * @template-implements ReadablePropertyInterface<T>
 */
final readonly class ReadableProperty implements ReadablePropertyInterface
{
    /**
     * @var \Closure():T
     */
    private \Closure $get;

    /**
     * @param callable():T $get
     */
    public function __construct(callable $get)
    {
        $this->get = $get(...);
    }

    /**
     * @return T
     */
    public function get(): mixed
    {
        return ($this->get)();
    }
}
