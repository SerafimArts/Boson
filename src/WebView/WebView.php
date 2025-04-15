<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use FFI\CData;
use Psr\EventDispatcher\EventDispatcherInterface;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Internal\WebView\WebViewEventHandler;
use Serafim\Boson\WebView\Binding\FunctionsMap;
use Serafim\Boson\WebView\Scripts\ScriptsMap;
use Serafim\Boson\WebView\Url\MemoizedUrlParser;
use Serafim\Boson\WebView\Url\NativeUrlParser;
use Serafim\Boson\WebView\Url\Url;
use Serafim\Boson\WebView\Url\UrlParserInterface;
use Serafim\Boson\Window\Window;

final class WebView implements WebViewInterface
{
    public readonly DelegateEventListener $events;

    public readonly ScriptsMap $scripts;

    public readonly FunctionsMap $functions;

    public Url $url {
        get {
            return $this->urlParser->parse($this->urlString);
        }
        set(Url|\Stringable|string $value) {
            $this->api->saucer_webview_set_url($this->ptr, (string) $value);
        }
    }

    public string $html {
        set(string|\Stringable $html) {
            $base64 = \base64_encode((string) $html);

            $this->url = \sprintf('data:text/html;base64,%s', $base64);
        }
    }

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
        // The WebView handle pointer is the same as the Window pointer.
        $this->ptr = $this->window->id->ptr;

        $this->scripts = new ScriptsMap(
            api: $this->api,
            webview: $this,
        );

        $this->functions = new FunctionsMap(
            scripts: $this->scripts,
            events: $this->events,
        );

        $this->handler = new WebViewEventHandler(
            api: $this->api,
            webview: $this,
            dispatcher: $this->events,
            urlParser: $this->urlParser,
            state: $this->state,
        );
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
