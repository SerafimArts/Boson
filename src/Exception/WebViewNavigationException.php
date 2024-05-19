<?php

declare(strict_types=1);

namespace Serafim\Boson\Exception;

class WebViewNavigationException extends WebViewException
{
    /**
     * @param non-empty-string $name
     */
    public static function fromErrorName(string $name, int $code): static
    {
        return new static($name, $code);
    }

    public static function fromBackedEnum(\BackedEnum $enum): static
    {
        return static::fromErrorName($enum->name, (int) $enum->value);
    }
}
