<?php

declare(strict_types=1);

namespace Local\Property;

/**
 * @template T of mixed
 */
interface WritablePropertyInterface
{
    /**
     * @param T $value
     */
    public function set(mixed $value): void;
}
