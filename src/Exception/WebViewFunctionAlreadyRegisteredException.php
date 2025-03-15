<?php

declare(strict_types=1);

namespace Serafim\Boson\Exception;

class WebViewFunctionAlreadyRegisteredException extends WebViewBindingException
{
    public static function becauseFunctionAlreadyRegistered(string $name, ?\Throwable $previous = null): self
    {
        $message = 'Cannot redeclare already defined function %s()';
        $message = \sprintf($message, $name);

        return new self($message, 0, $previous);
    }
}
