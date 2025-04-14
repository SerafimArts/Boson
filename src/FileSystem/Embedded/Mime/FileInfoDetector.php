<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem\Embedded\Mime;

use finfo as ExtFileInfo;

final readonly class FileInfoDetector implements DataDetectorInterface, FileDetectorInterface
{
    private ?ExtFileInfo $finfo;

    public function __construct(
        private ?DataDetectorInterface $dataDetectorDelegate = null,
        private ?FileDetectorInterface $fileDetectorDelegate = null,
        /**
         * Provides reference to "magic" `ext-finfo` file.
         *
         * @var non-empty-string|null
         */
        private ?string $magic = null,
    ) {
        $this->finfo = $this->tryCreateFileInfo();
    }

    private function tryCreateFileInfo(): ?ExtFileInfo
    {
        if (!\extension_loaded('fileinfo')) {
            return null;
        }

        return $this->createFileInfo();
    }

    private function createFileInfo(): ExtFileInfo
    {
        if ($this->magic === null || $this->magic === '') {
            return new ExtFileInfo(\FILEINFO_MIME_TYPE);
        }

        return new ExtFileInfo(\FILEINFO_MIME_TYPE, $this->magic);
    }

    public function detectByData(string $data): ?string
    {
        $result = $this->finfo?->buffer($data);

        if (\is_string($result) && $result !== '') {
            return \strtolower($result);
        }

        return $this->dataDetectorDelegate?->detectByData($data);
    }

    public function detectByFile(string $pathname): ?string
    {
        $result = $this->finfo?->file($pathname);

        if (\is_string($result) && $result !== '') {
            return \strtolower($result);
        }

        return $this->fileDetectorDelegate?->detectByFile($pathname);
    }
}
