<?php

declare(strict_types=1);

namespace Local\Id;

/**
 * @template T of mixed
 */
interface IdentifiableInterface
{
    /**
     * Returns an unique {@see IdInterface} value object representation of
     * the message identifier.
     *
     * @return IdInterface<T>
     */
    public function getId(): IdInterface;
}
