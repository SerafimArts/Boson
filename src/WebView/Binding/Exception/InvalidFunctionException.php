<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Binding\Exception;

final class InvalidFunctionException extends BindingException
{
    public static function becauseFunctionNotDefined(string $name, ?\Throwable $previous = null): self
    {
        $message = \sprintf('RPC function "%s" has not been defined', $name);

        return new self($message, 0, $previous);
    }
}
