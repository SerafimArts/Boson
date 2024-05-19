<?php

declare(strict_types=1);

namespace Local\Property\Exception;

final class PropertyNotReadableException extends PropertyException
{
    /**
     * @param class-string $class
     * @param non-empty-string $name
     */
    public static function fromPropertyName(string $class, string $name): self
    {
        $message = \sprintf('Property not readable: %s::$%s', $class, $name);

        return new self($message);
    }
}
