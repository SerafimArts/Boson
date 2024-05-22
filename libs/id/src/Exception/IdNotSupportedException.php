<?php

declare(strict_types=1);

namespace Local\Id\Exception;

class IdNotSupportedException extends IdException
{
    final public const int ERROR_CODE_INVALID_PLATFORM = 0x01 + parent::ERROR_CODE_LAST;

    protected const int ERROR_CODE_LAST = self::ERROR_CODE_INVALID_PLATFORM;

    public static function fromInvalidPlatform(string $expected, string $actual): static
    {
        $message = 'The current platform does not support %s identifiers, only %s is allowed';
        $message = \sprintf($message, $expected, $actual);

        return new static($message, self::ERROR_CODE_INVALID_PLATFORM);
    }
}
