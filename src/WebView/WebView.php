<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use FFI\CData;
use JetBrains\PhpStorm\Language;
use Psr\EventDispatcher\EventDispatcherInterface;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Internal\WebView\WebViewEventHandler;
use Serafim\Boson\WebView\Url\MemoizedUrlParser;
use Serafim\Boson\WebView\Url\NativeUrlParser;
use Serafim\Boson\WebView\Url\Url;
use Serafim\Boson\WebView\Url\UrlParserInterface;
use Serafim\Boson\Window\Window;

final class WebView implements WebViewInterface
{
    public Url $url {
        get {
            return $this->urlParser->parse($this->urlString);
        }
        set(Url|\Stringable|string $value) {
            $this->api->saucer_webview_set_url($this->ptr, (string) $value);
        }
    }

    public readonly DelegateEventListener $events;

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
    private UrlParserInterface $urlParser;

    /**
     * Contains unique index filename
     *
     * @var non-empty-string
     */
    private readonly string $index;

    /**
     * Contains an internal bridge between system {@see LibSaucer} events
     * and the PSR {@see WebView::$events} dispatcher.
     *
     * @phpstan-ignore property.onlyWritten
     */
    private readonly WebViewEventHandler $handler;

    public function __construct(
        /**
         * Contains shared WebView API library.
         */
        private readonly LibSaucer $api,
        public readonly Window $window,
        public readonly WebViewCreateInfo $info,
        EventDispatcherInterface $dispatcher,
    ) {
        $this->urlParser = new MemoizedUrlParser(
            delegate: new NativeUrlParser(),
        );

        $this->events = new DelegateEventListener($dispatcher);
        $this->index = \spl_object_hash($this) . '/index.html';
        // The WebView handle pointer is the same as the Window pointer.
        $this->ptr = $this->window->id->ptr;

        $this->handler = new WebViewEventHandler(
            api: $this->api,
            webview: $this,
            dispatcher: $this->events,
            urlParser: $this->urlParser,
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
