<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Requests\Exception;

final class UnprocessableRequestException extends RequestException
{
    public static function becauseRequestIsUnprocessable(string $code, ?\Throwable $previous = null): self
    {
        $message = 'Request "%s" could not be processed because application is not running';
        $message = \sprintf($message, \addcslashes($code, '"'));

        return new self($message, 0, $previous);
    }
}
