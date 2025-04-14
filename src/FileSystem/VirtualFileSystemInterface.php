<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem;

/**
 * @template-extends \Traversable<array-key, VirtualFile>
 */
interface VirtualFileSystemInterface extends \Traversable, \Countable
{
    /**
     * Unmount virtual file from WebView`s VFS and return {@see true}
     * in success (file has been defined) or {@see false} instead.
     *
     * @param non-empty-string $name the name of the virtual file
     */
    public function unmount(string $name): bool;

    /**
     * Load payload from passed data (RAW bytes) as virtual file.
     *
     * ```
     * $file = $vfs->mount('index.html', '<b>hello world</b>');
     *
     * $webview->uri = $file->uri;
     * ```
     *
     * @param non-empty-string $name the name of the virtual file
     * @param non-empty-string|null $mime optional mime file type for correct
     *        WebView representation
     */
    public function mount(string $name, string $data, ?string $mime = null): VirtualFile;

    /**
     * Load payload from the local filesystem as virtual file.
     *
     * ```
     * $file = $vfs->mountFromPathname('index.html', __DIR__ . '/path/to/file.txt');
     *
     * $webview->uri = $file->uri;
     * ```
     *
     * @param non-empty-string $name the name of the virtual file
     * @param non-empty-string $pathname physical real pathname to the file
     * @param non-empty-string|null $mime optional mime file type for correct
     *        WebView representation
     */
    public function mountFromPathname(string $name, string $pathname, ?string $mime = null): VirtualFile;

    /**
     * @return int<0, max>
     */
    public function count(): int;
}
