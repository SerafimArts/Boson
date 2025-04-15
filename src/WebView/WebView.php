<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use FFI\CData;
use JetBrains\PhpStorm\Language;
use Psr\EventDispatcher\EventDispatcherInterface;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Internal\Application\ProcessUnlockPlaceholder;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Internal\WebView\WebViewEventHandler;
use Serafim\Boson\WebView\Binding\WebViewFunctionsMap;
use Serafim\Boson\WebView\Requests\WebViewRequests;
use Serafim\Boson\WebView\Scripts\WebViewScriptsSet;
use Serafim\Boson\WebView\Url\MemoizedUrlParser;
use Serafim\Boson\WebView\Url\NativeUrlParser;
use Serafim\Boson\WebView\Url\Url;
use Serafim\Boson\WebView\Url\UrlParserInterface;
use Serafim\Boson\Window\Window;

final class WebView implements WebViewInterface
{
    public readonly DelegateEventListener $events;

    public readonly WebViewScriptsSet $scripts;

    public readonly WebViewFunctionsMap $functions;

    public readonly WebViewRequests $requests;

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
        private readonly ProcessUnlockPlaceholder $placeholder,
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

        $this->scripts = new WebViewScriptsSet(
            api: $this->api,
            webview: $this,
        );

        $this->functions = new WebViewFunctionsMap(
            scripts: $this->scripts,
            events: $this->events,
        );

        $this->requests = new WebViewRequests(
            webview: $this,
            placeholder: $this->placeholder,
        );

        $this->handler = new WebViewEventHandler(
            api: $this->api,
            webview: $this,
            dispatcher: $this->events,
            urlParser: $this->urlParser,
            state: $this->state,
        );

        foreach ($this->info->functions as $function => $callback) {
            $this->functions->bind($function, $callback);
        }

        foreach ($this->info->scripts as $script) {
            $this->scripts->add($script);
        }

        if ($this->info->url !== null) {
            $this->url = $this->info->url;
        }

        if ($this->info->html !== null) {
            $this->html = $this->info->html;
        }
    }

    public function bind(string $function, \Closure $callback): void
    {
        $this->functions->bind($function, $callback);
    }

    public function eval(#[Language('JavaScript')] string $code): void
    {
        $this->scripts->eval($code);
    }

    public function request(#[Language('JavaScript')] string $code): mixed
    {
        return $this->requests->send($code);
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
