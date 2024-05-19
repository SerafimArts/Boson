<?php

declare(strict_types=1);

namespace Local\Com\Exception;

class ComException extends \RuntimeException
{
    final public function __construct(string $message, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
