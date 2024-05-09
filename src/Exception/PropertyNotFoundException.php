<?php

declare(strict_types=1);

namespace Serafim\WinUI\Exception;

final class PropertyNotFoundException extends PropertyException
{
    /**
     * @param class-string $class
     * @param non-empty-string $name
     */
    public static function fromPropertyName(string $class, string $name): self
    {
        $message = \sprintf('Undefined property: %s::$%s', $class, $name);

        return new self($message);
    }
}
