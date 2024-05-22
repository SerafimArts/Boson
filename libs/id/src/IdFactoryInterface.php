<?php

declare(strict_types=1);

namespace Local\Id;

interface IdFactoryInterface
{
    /**
     * Returns new identifier instance created from any value.
     *
     * ```php
     *  $id = $factory->create('550e8400-e29b-41d4-a716-446655440000');
     *  // IdInterface<string> { value: "550e8400-e29b-41d4-a716-446655440000" }
     *
     *  $id = $factory->create(0xDEAD_BEEF);
     *  // IdInterface<int> { value: 3735928559 }
     *
     *  $id = $factory->create();
     *  // IdInterface<null> { value: null }
     * ```
     *
     * @template T of mixed
     *
     * @param T $id
     *
     * @return IdInterface<T>
     *
     * @throws \Throwable In case of an ID creation error occurrence.
     */
    public function create(mixed $id = null): IdInterface;
}
