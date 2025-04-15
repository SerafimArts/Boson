<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Requests\Exception;

final class UnprocessableRequestException extends RequestException
{
    public static function becauseRequestIsUnprocessable(string $code, ?\Throwable $previous = null): self
    {
        $message = 'The Request("%s") could not be processed because the '
            . 'application terminated before returning sync (blocking) result';
        $message = \sprintf($message, \addcslashes($code, '"'));

        return new self($message, 0, $previous);
    }
}
