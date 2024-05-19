<?php

declare(strict_types=1);

namespace Local\Property;

/**
 * @template T of mixed
 */
interface ReadablePropertyInterface
{
    /**
     * @return T
     */
    public function get(): mixed;
}
