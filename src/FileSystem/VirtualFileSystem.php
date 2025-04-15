<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem;

use Serafim\Boson\FileSystem\Embedded\EmbeddedStorage;
use Serafim\Boson\FileSystem\Embedded\Embedding;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Internal\Saucer\SaucerLaunch;
use Serafim\Boson\Window\Window;

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
        private readonly Window $window,
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
            embedding: $this->embeddings->load($data, $mime),
        );
    }

    public function mountFromPathname(string $name, string $pathname, ?string $mime = null): VirtualFile
    {
        return $this->loadEmbedding(
            name: $name,
            embedding: $this->embeddings->loadFromPathname($pathname, $mime),
        );
    }

    /**
     * @param non-empty-string $name
     */
    private function loadEmbedding(string $name, Embedding $embedding): VirtualFile
    {
        $name = VirtualFile::formatName($name);

        $this->api->saucer_webview_embed_file(
            $this->window->id->ptr,
            $name,
            $embedding->id->ptr,
            SaucerLaunch::SAUCER_LAUNCH_SYNC,
        );

        return $this->files[$name] = new VirtualFile(
            api: $this->api,
            window: $this->window,
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
}
