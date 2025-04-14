<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem\Embedded;

use Serafim\Boson\FileSystem\Memory\Memory;
use Serafim\Boson\Kernel\LibSaucer;

/**
 * Reference to the embedded entry.
 */
final class Embedding
{
    /**
     * Facade property for the inner {@see Memory::$size} property.
     */
    public int $size {
        get => $this->memory->size;
    }

    /**
     * Facade property for the inner {@see Memory::$data} property.
     */
    public string $data {
        get => $this->memory->data;
    }

    public function __construct(
        /**
         * Shared API library.
         */
        private readonly LibSaucer $api,
        /**
         * An unique identifier of the embedded entry.
         */
        public readonly EmbeddingId $id,
        /**
         * The mime type defined for this embedding.
         *
         * @var non-empty-string
         */
        public readonly string $mime,
        /**
         * Provides the memory object referenced by this embedding.
         */
        public readonly Memory $memory,
    ) {}

    public function __debugInfo(): array
    {
        return [
            'id' => $this->id,
            'mime' => $this->mime,
            'memory' => $this->memory,
        ];
    }

    public function __destruct()
    {
        $this->api->saucer_embed_free($this->id->ptr);
    }
}
