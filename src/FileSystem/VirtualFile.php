<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem;

use Serafim\Boson\FileSystem\Embedded\Embedding;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Window\WindowId;

final class VirtualFile
{
    /**
     * @var non-empty-string
     */
    private const string DEFAULT_VFS_PATH_DELIMITER = '/';

    /**
     * @var non-empty-string
     */
    private const string DEFAULT_VFS_URI = 'saucer://embedded/';

    /**
     * Facade property for the inner {@see Embedding::$size} property.
     */
    public int $size {
        get => $this->embedding->size;
    }

    /**
     * Facade property for the inner {@see Embedding::$data} property.
     */
    public string $data {
        get => $this->embedding->data;
    }

    /**
     * Facade property for the inner {@see Embedding::$mime} field.
     */
    public string $mime {
        get => $this->embedding->mime;
    }

    /**
     * Provides a URI by which to access this file from WebView.
     *
     * @var non-empty-string
     */
    public readonly string $uri;

    public function __construct(
        /**
         * Shared API library.
         */
        private readonly LibSaucer $api,
        /**
         * An identifier of the window (and webview) that owns
         * the specified file.
         */
        private readonly WindowId $windowId,
        /**
         * The name of the file, unique within the window (webview).
         *
         * @var non-empty-string
         */
        public readonly string $name,
        public readonly Embedding $embedding,
    ) {
        $this->uri = self::DEFAULT_VFS_URI . $this->name;
    }

    /**
     * Format and normalize virtual file name.
     *
     * @param non-empty-string $name
     *
     * @return non-empty-string
     */
    public static function formatName(string $name): string
    {
        // Normalize path delimiters to *nix
        $name = \str_replace('\\', self::DEFAULT_VFS_PATH_DELIMITER, $name);

        $segments = [];

        foreach (\explode(self::DEFAULT_VFS_PATH_DELIMITER, $name) as $segment) {
            // Skip dots (".") and empty ("") segments
            if ($segment === '.' || $segment === '') {
                continue;
            }

            if ($segment === '..') {
                \array_pop($segments);
            } else {
                $segments[] = $segment;
            }
        }

        return \implode(self::DEFAULT_VFS_PATH_DELIMITER, $segments);
    }

    /**
     * Unmount virtual file from WebView`s VFS
     */
    public function unmount(): void
    {
        $this->api->saucer_webview_clear_embedded_file($this->windowId->ptr, $this->name);
    }

    public function __destruct()
    {
        $this->unmount();
    }
}
