<?php

declare(strict_types=1);

namespace Local\Id\Exception;

class IdOverflowException extends IdException
{
    final public const int ERROR_CODE_OVERFLOW = 0x01 + parent::ERROR_CODE_LAST;

    protected const int ERROR_CODE_LAST = self::ERROR_CODE_OVERFLOW;

    /**
     * @param non-empty-string $max
     */
    public static function fromMaxValue(string $max): static
    {
        $message = 'Cannot create a new ID because the ID has reached its maximum value %s';

        return new static(\sprintf($message, $max), self::ERROR_CODE_OVERFLOW);
    }

    /**
     * @param class-string $class
     * @param non-empty-string $max
     */
    public static function fromMaxValueOfClass(string $class, string $max): static
    {
        return static::fromMaxValue(\sprintf('%s(%s)', $class, $max));
    }
}
