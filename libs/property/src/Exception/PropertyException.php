<?php

declare(strict_types=1);

namespace Local\Property\Exception;

abstract class PropertyException extends \OutOfBoundsException
{
    public function __construct(string $message, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $trace = $this->getNonInternalFileAndLine($this->getTrace());

        if ($trace !== null) {
            [$this->file, $this->line] = $trace;
        }
    }

    /**
     * @param list<array{
     *     line?: int,
     *     file?: string,
     *     ...
     * }> $trace
     *
     * @return array{string, int}|null
     */
    private function getNonInternalFileAndLine(array $trace): ?array
    {
        $directory = \dirname(__DIR__);

        foreach ($trace as $item) {
            if (!isset($item['file'], $item['line']) || \str_starts_with($item['file'], $directory)) {
                continue;
            }

            return [$item['file'], $item['line']];
        }

        return null;
    }
}
