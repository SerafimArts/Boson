<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use FFI\CData;
use JetBrains\PhpStorm\Language;
use Serafim\Boson\WebView\Uri\MemoizedUriParser;
use Serafim\Boson\WebView\Uri\Uri;
use Serafim\Boson\Shared\Saucer\LibSaucer;
use Serafim\Boson\WebView\Uri\NativeUriParser;
use Serafim\Boson\WebView\Uri\UriParserInterface;
use Serafim\Boson\Window\Window;

final class WebView implements WebViewInterface
{
    /**
     * Window's webview pointer (handle).
     */
    private readonly CData $ptr;

    /**
     * Contains current non-memoized webview url string.
     */
    private string $urlString {
        /**
         * Gets current non-memoized webview url string.
         */
        get {
            $result = $this->api->saucer_webview_url($this->ptr);

            try {
                return \FFI::string($result);
            } finally {
                \FFI::free($result);
            }
        }
    }

    private UriParserInterface $uriParser;

    public Uri $uri {
        get {
            return $this->uriParser->parse($this->urlString);
        }
        set(Uri|\Stringable|string $value) {
            $this->api->saucer_webview_set_url($this->ptr, (string) $value);
        }
    }

    /**
     * Contains unique index filename
     *
     * @var non-empty-string
     */
    private readonly string $index;

    public function __construct(
        /**
         * Contains shared WebView API library.
         */
        private readonly LibSaucer $api,
        /**
         * Provides parent window instance.
         */
        public readonly Window $window,
        /**
         * WebView creation info DTO.
         */
        public readonly WebViewCreateInfo $info = new WebViewCreateInfo(),
    ) {
        $this->uriParser = new MemoizedUriParser(
            delegate: new NativeUriParser(),
        );

        // The WebView handle pointer is the same as the Window pointer.
        $this->ptr = $this->window->id->ptr;

        $this->index = \spl_object_hash($this) . '/index.html';
    }

    public function loadHtml(#[Language('HTML')] string $html): void
    {
        $this->window->fs->mount($this->index, $html, 'text/html');

        $this->loadFromVirtualFilesystem($this->index);
    }

    public function loadFromVirtualFilesystem(string $name): void
    {
        $this->api->saucer_webview_serve($this->ptr, $name);
    }

    public function loadFromLocalFilesystem(string $pathname): void
    {
        $this->window->fs->mountFromPathname($this->index, $pathname, 'text/html');

        $this->loadFromVirtualFilesystem($this->index);
    }

    public function forward(): void
    {
        $this->api->saucer_webview_forward($this->ptr);
    }

    public function back(): void
    {
        $this->api->saucer_webview_back($this->ptr);
    }

    public function reload(): void
    {
        $this->api->saucer_webview_reload($this->ptr);
    }
}
