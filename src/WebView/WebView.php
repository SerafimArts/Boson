<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use FFI\CData;
use JetBrains\PhpStorm\Language;
use Psr\EventDispatcher\EventDispatcherInterface;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Kernel\LibSaucer;
use Serafim\Boson\WebView\Runtime\WebViewEventHandler;
use Serafim\Boson\WebView\Uri\MemoizedUriParser;
use Serafim\Boson\WebView\Uri\NativeUriParser;
use Serafim\Boson\WebView\Uri\Uri;
use Serafim\Boson\WebView\Uri\UriParserInterface;
use Serafim\Boson\Window\Window;

final class WebView implements WebViewInterface
{
    /**
     * See {@see WebViewInterface::$uri} property description.
     */
    public Uri $uri {
        get {
            return $this->uriParser->parse($this->urlString);
        }
        set(Uri|\Stringable|string $value) {
            $this->api->saucer_webview_set_url($this->ptr, (string) $value);
        }
    }

    /**
     * See {@see WebViewInterface::$events} property description.
     */
    public readonly DelegateEventListener $events;

    /**
     * See {@see WebViewInterface::$state} property description.
     */
    public private(set) State $state = State::Loading;

    /**
     * Internal window's webview pointer (handle).
     */
    private readonly CData $ptr;

    /**
     * Contains current non-memoized webview url string.
     */
    private string $urlString {
        get {
            $result = $this->api->saucer_webview_url($this->ptr);

            try {
                return \FFI::string($result);
            } finally {
                \FFI::free($result);
            }
        }
    }

    /**
     * Contains WebView URI parser.
     */
    private UriParserInterface $uriParser;

    /**
     * Contains unique index filename
     *
     * @var non-empty-string
     */
    private readonly string $index;

    /**
     * Contains an internal bridge between system {@see LibSaucer} events
     * and the PSR {@see WebView::$events} dispatcher.
     */
    private readonly WebViewEventHandler $handler;

    public function __construct(
        /**
         * Contains shared WebView API library.
         */
        private readonly LibSaucer $api,
        /**
         * Provides parent Window instance.
         */
        public readonly Window $window,
        /**
         * WebView creation info DTO.
         */
        public readonly WebViewCreateInfo $info,
        EventDispatcherInterface $dispatcher,
    ) {
        $this->uriParser = new MemoizedUriParser(
            delegate: new NativeUriParser(),
        );

        $this->events = new DelegateEventListener($dispatcher);
        $this->index = \spl_object_hash($this) . '/index.html';
        // The WebView handle pointer is the same as the Window pointer.
        $this->ptr = $this->window->id->ptr;

        $this->handler = new WebViewEventHandler(
            api: $this->api,
            webView: $this,
            dispatcher: $this->events,
            uriParser: $this->uriParser,
            state: $this->state,
        );
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
