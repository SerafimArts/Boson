<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem\Memory\Exception;

final class FileNotReadableStorageException extends FileStorageException
{
    public const int CODE_NOT_READABLE = 1;
    public const int CODE_NOT_FOUND = 2;

    public static function becauseFileNotReadable(string $pathname, ?\Throwable $previous = null): self
    {
        $message = \sprintf('File "%s" is not readable', $pathname);

        return new self($pathname, $message, self::CODE_NOT_READABLE, $previous);
    }

    public static function becauseFileNotFound(string $pathname, ?\Throwable $previous = null): self
    {
        $message = \sprintf('File "%s" not found', $pathname);

        return new self($pathname, $message, self::CODE_NOT_FOUND, $previous);
    }
}
