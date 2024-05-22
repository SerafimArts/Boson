<?php

declare(strict_types=1);

namespace Local\Id;

/**
 * Identifier value object representation.
 *
 * @template TValue of mixed
 */
interface IdInterface extends \Stringable
{
    /**
     * Checks the value object equivalence.
     *
     * @param IdInterface<mixed> $id
     */
    public function equals(self $id): bool;

    /**
     * Returns the primitive scalar value of the value object.
     *
     * @return TValue
     */
    public function toPrimitive(): mixed;

    /**
     * Magic method {@link https://www.php.net/manual/en/language.oop5.magic.php#object.tostring}
     * allows a class to decide how it will react when it is treated
     * like a string.
     *
     * @return non-empty-string returns string representation of the object
     *         that implements this interface (and/or {@see __toString()}
     *         magic method).
     */
    public function __toString(): string;
}
