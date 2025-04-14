<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem\Memory;

use FFI\CData;
use Serafim\Boson\FileSystem\Memory\Exception\FileNotReadableStorageException;
use Serafim\Boson\FileSystem\Memory\Exception\StorageException;
use Serafim\Boson\Internal\Saucer\LibSaucer;

/**
 * Provides raw data storage
 */
final readonly class MemoryStorage
{
    private const int MEMORY_MAX_SIZE = 32767;

    public function __construct(
        private LibSaucer $api,
    ) {}

    private function loadCString(string $data): CData
    {
        $size = \strlen($data);

        $string = $this->api->new("char[$size]");

        \FFI::memcpy($string, $data, $size);

        return $string;
    }

    /**
     * Load payload from passed data (RAW bytes).
     *
     * @api
     */
    public function load(string $data): Memory
    {
        $string = $this->loadCString($data);
        $uint8Array = $this->api->cast('uint8_t*', \FFI::addr($string));

        $length = \strlen($data);

        if ($length > self::MEMORY_MAX_SIZE) {
            throw new StorageException(\sprintf(
                'The file size must not exceed %d bytes, %d bytes given',
                self::MEMORY_MAX_SIZE,
                $length,
            ));
        }

        $stashId = $this->api->saucer_stash_from($uint8Array, $length);

        $storageId = MemoryId::fromStashHandle($this->api, $stashId);

        return new Memory($this->api, $storageId);
    }

    /**
     * Load payload from the local filesystem by passed pathname.
     *
     * @api
     *
     * @param non-empty-string $pathname
     *
     * @throws FileNotReadableStorageException In case of file not found
     * @throws FileNotReadableStorageException In case of file not readable
     */
    public function loadFromPathname(string $pathname): Memory
    {
        if (!\is_file($pathname)) {
            throw FileNotReadableStorageException::becauseFileNotFound($pathname);
        }

        if (!\is_readable($pathname)) {
            throw FileNotReadableStorageException::becauseFileNotReadable($pathname);
        }

        return $this->load((string) \file_get_contents($pathname));
    }
}
