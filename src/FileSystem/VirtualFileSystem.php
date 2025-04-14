<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem;

use Serafim\Boson\FileSystem\Embedded\EmbeddedStorage;
use Serafim\Boson\FileSystem\Embedded\Embedding;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Internal\Saucer\SaucerLaunch;
use Serafim\Boson\Window\WindowId;

/**
 * @template-implements \IteratorAggregate<array-key, VirtualFile>
 */
final class VirtualFileSystem implements \IteratorAggregate, VirtualFileSystemInterface
{
    /**
     * @var array<non-empty-string, VirtualFile>
     */
    private array $files = [];

    private readonly EmbeddedStorage $embeddings;

    public function __construct(
        private readonly LibSaucer $api,
        private readonly WindowId $windowId,
    ) {
        $this->embeddings = new EmbeddedStorage($this->api);
    }

    public function unmount(string $name): bool
    {
        $name = VirtualFile::formatName($name);

        if (isset($this->files[$name])) {
            $this->files[$name]->unmount();

            unset($this->files[$name]);

            return true;
        }

        return false;
    }

    /**
     * Load payload from passed data (RAW bytes) as virtual file.
     *
     * @api
     *
     * @param non-empty-string $name
     * @param non-empty-string|null $mime
     */
    public function mount(string $name, string $data, ?string $mime = null): VirtualFile
    {
        return $this->loadEmbedding(
            name: $name,
            embedding: $this->embeddings->load(
                data: $data,
                mime: $mime,
            ),
        );
    }

    public function mountFromPathname(string $name, string $pathname, ?string $mime = null): VirtualFile
    {
        return $this->loadEmbedding(
            name: $name,
            embedding: $this->embeddings->loadFromPathname(
                pathname: $pathname,
                mime: $mime,
            ),
        );
    }

    /**
     * @param non-empty-string $name
     */
    private function loadEmbedding(string $name, Embedding $embedding): VirtualFile
    {
        $name = VirtualFile::formatName($name);

        $this->api->saucer_webview_embed_file(
            $this->windowId->ptr,
            $name,
            $embedding->id->ptr,
            SaucerLaunch::SAUCER_LAUNCH_SYNC,
        );

        return $this->files[$name] = new VirtualFile(
            api: $this->api,
            windowId: $this->windowId,
            name: $name,
            embedding: $embedding,
        );
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->files);
    }

    public function count(): int
    {
        return \count($this->files);
    }

    public function __destruct()
    {
        $this->api->saucer_webview_clear_embedded($this->windowId->ptr);
    }
}
