<?php

declare(strict_types=1);

namespace Serafim\Boson\Vfs\Embedded;

use Serafim\Boson\Shared\Saucer\LibSaucer;
use Serafim\Boson\Vfs\Embedded\Mime\DataDetectorInterface;
use Serafim\Boson\Vfs\Embedded\Mime\ExtensionFileDetector;
use Serafim\Boson\Vfs\Embedded\Mime\FileDetectorInterface;
use Serafim\Boson\Vfs\Embedded\Mime\FileInfoDetector;
use Serafim\Boson\Vfs\Memory\Memory;
use Serafim\Boson\Vfs\Memory\MemoryStorage;

final readonly class EmbeddedStorage
{
    /**
     * @var non-empty-string
     */
    private const string DEFAULT_MIME_TYPE = 'text/plain';

    private MemoryStorage $storage;

    private FileDetectorInterface $fileDetector;
    private DataDetectorInterface $dataDetector;

    public function __construct(
        private LibSaucer $api,
        /**
         * @var non-empty-string
         */
        private string $defaultMimeType = self::DEFAULT_MIME_TYPE,
    ) {
        $this->storage = new MemoryStorage($this->api);

        $this->dataDetector = $this->fileDetector = new FileInfoDetector(
            fileDetectorDelegate: new ExtensionFileDetector(),
        );
    }

    /**
     * Load payload from passed data (RAW bytes) as embedding.
     *
     * @api
     * @param non-empty-string $pathname
     * @param non-empty-string|null $mime
     */
    public function load(string $data, ?string $mime = null): Embedding
    {
        return $this->createFromMemory(
            memory: $this->storage->load($data),
            mime: $mime ?? $this->dataDetector->detectByData($data)
                ?? $this->defaultMimeType,
        );
    }

    /**
     * Load payload from the local filesystem by passed pathname as embedding.
     *
     * @api
     * @param non-empty-string $pathname
     * @param non-empty-string|null $mime
     */
    public function loadFromPathname(string $pathname, ?string $mime = null): Embedding
    {
        return $this->createFromMemory(
            memory: $this->storage->loadFromPathname($pathname),
            mime: $mime ?? $this->fileDetector->detectByFile($pathname)
                ?? $this->defaultMimeType,
        );
    }

    /**
     * @param non-empty-string $mime
     */
    private function createFromMemory(Memory $memory, string $mime): Embedding
    {
        $handle = $this->api->saucer_embed($memory->id->ptr, $mime);
        $id = EmbeddingId::fromEmbeddedFileHandle($this->api, $handle);

        return new Embedding(
            api: $this->api,
            id: $id,
            mime: $mime,
            memory: $memory,
        );
    }
}
