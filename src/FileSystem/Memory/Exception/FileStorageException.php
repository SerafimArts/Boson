<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem\Memory\Exception;

abstract class FileStorageException extends StorageException
{
    public function __construct(
        /**
         * Path to the file that was trying to be read.
         *
         * @var non-empty-string
         */
        public readonly string $pathname,
        string $message,
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
