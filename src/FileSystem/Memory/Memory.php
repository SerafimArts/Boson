<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem\Memory;

use Serafim\Boson\Internal\Saucer\LibSaucer;

/**
 * An allocated memory object.
 */
final class Memory
{
    /**
     * Gets size of loaded payload in bytes.
     *
     * @var int<0, 32767>
     */
    public int $size {
        get => $this->size ??= \max(0, $this->api->saucer_stash_size($this->id->ptr));
    }

    /**
     * Gets data of the loaded payload.
     */
    public string $data {
        get {
            $data = $this->api->saucer_stash_data($this->id->ptr);

            return \FFI::string($data, $this->size);
        }
    }

    public function __construct(
        /**
         * Shared API library.
         */
        private readonly LibSaucer $api,
        /**
         * An unique identifier of the allocated memory entry.
         */
        public readonly MemoryId $id,
    ) {}

    public function __debugInfo(): array
    {
        return [
            'id' => $this->id,
        ];
    }

    public function __destruct()
    {
        $this->api->saucer_stash_free($this->id->ptr);
    }
}
