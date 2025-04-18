<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use FFI\CData;
use JetBrains\PhpStorm\Language;
use Psr\EventDispatcher\EventDispatcherInterface;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Dispatcher\EventListener;
use Serafim\Boson\Internal\ProcessUnlockPlaceholder;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Shared\Marker\BlockingOperation;
use Serafim\Boson\WebView\Binding\Exception\FunctionAlreadyDefinedException;
use Serafim\Boson\WebView\Binding\WebViewFunctionsMap;
use Serafim\Boson\WebView\Internal\WebViewEventHandler;
use Serafim\Boson\WebView\Requests\WebViewRequests;
use Serafim\Boson\WebView\Scripts\WebViewScriptsSet;
use Serafim\Boson\WebView\Url\MemoizedUrlParser;
use Serafim\Boson\WebView\Url\NativeUrlParser;
use Serafim\Boson\WebView\Url\UrlParserInterface;
use Serafim\Boson\Window\Window;

final class WebView
{
    /**
     * Gets access to the listener of the webview events
     * and intention subscriptions.
     */
    public readonly EventListener $events;

    /**
     * Gets access to the scripts API of the webview.
     */
    public readonly WebViewScriptsSet $scripts;

    /**
     * Gets access to the functions API of the webview.
     */
    public readonly WebViewFunctionsMap $functions;

    /**
     * Gets access to the requests API of the webview.
     */
    public readonly WebViewRequests $requests;

    /**
     * Contains webview URI instance.
     */
    public Url $url {
        /**
         * Gets current webview URI instance.
         *
         * ```
         * echo $webview->uri;          // http://example.com
         * echo $webview->uri->host;    // example.com
         * echo $webview->uri->scheme;  // http
         * ```
         */
        get => $this->urlParser->parse($this->urlString);
        /**
         * Updates URI of the webview.
         *
         * This can also be considered as navigation to a specific web page.
         *
         * ```
         * $webview->uri = 'http://example.com';
         * ```
         *
         * Don't forget that you can also use any compatible URI interface,
         * such as PSR-compatible.
         *
         * ```
         * $webview->uri = new Psr17\AnyUriFactory()
         *      ->create('http://example.com');
         *
         * // OR
         *
         * $webview->uri = new Psr7\AnyUri('http://example.com');
         * ```
         */
        set(Url|\Stringable|string $value) {
            $this->api->saucer_webview_set_url($this->ptr, (string) $value);
        }
    }

    /**
     * Load HTML content into the WebView.
     */
    public string $html {
        set(#[Language('HTML')] string|\Stringable $html) {
            $base64 = \base64_encode((string) $html);

            $this->url = \sprintf('data:text/html;base64,%s', $base64);
        }
    }

    /**
     * Gets webview status.
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
    private readonly UrlParserInterface $urlParser;

    /**
     * Contains an internal bridge between system {@see LibSaucer} events
     * and the PSR {@see WebView::$events} dispatcher.
     *
     * @phpstan-ignore property.onlyWritten
     */
    private readonly WebViewEventHandler $handler;

    /**
     * @internal Please do not use the constructor directly. There is a
     *           corresponding {@see WindowFactoryInterface::create()} method
     *           for creating new windows with single webview child instance,
     *           which ensures safe creation.
     *           ```
     *           $app = new Application();
     *
     *           // Should be used instead of calling the constructor
     *           $window = $app->windows->create();
     *
     *           // Access to webview child instance
     *           $webview = $window->webview;
     *           ```
     */
    public function __construct(
        /**
         * Contains shared WebView API library.
         */
        private readonly LibSaucer $api,
        /**
         * Contains an internal application placeholder to unlock the
         * webview process workflow.
         */
        private readonly ProcessUnlockPlaceholder $placeholder,
        /**
         * Gets parent application window instance to which
         * this webview instance belongs.
         */
        public readonly Window $window,
        /**
         * Gets information DTO about the webview with which it was created.
         */
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

    /**
     * Binds a PHP callback to a new global JavaScript function.
     *
     * Note: This is facade method of the {@see WebViewFunctionsMap::bind()},
     *       that provides by the {@see $functions} field. This means that
     *       calling `$webview->functions->bind(...)` should have the same effect.
     *
     * @api
     *
     * @uses WebViewFunctionsMap::bind() WebView Functions API
     *
     * @param non-empty-string $function
     *
     * @throws FunctionAlreadyDefinedException in case of function binding error
     */
    public function bind(string $function, \Closure $callback): void
    {
        $this->functions->bind($function, $callback);
    }

    /**
     * Evaluates arbitrary JavaScript code.
     *
     * Note: This is facade method of the {@see WebViewScriptsSet::eval()},
     *       that provides by the {@see $scripts} field. This means that
     *       calling `$webview->scripts->eval(...)` should have the same effect.
     *
     * @api
     *
     * @uses WebViewScriptsSet::eval() WebView Scripts API
     *
     * @param string $code A JavaScript code for execution
     */
    public function eval(#[Language('JavaScript')] string $code): void
    {
        $this->scripts->eval($code);
    }

    /**
     * Requests arbitrary data from webview using JavaScript code.
     *
     * Note: This is facade method of the {@see WebViewRequests::send()},
     *       that provides by the {@see $requests} field. This means that
     *       calling `$webview->requests->send(...)` should have the same effect.
     *
     * @api
     *
     * @uses WebViewRequests::send() WebView Requests API
     *
     * @param string $code A JavaScript code for execution
     */
    #[BlockingOperation]
    public function request(#[Language('JavaScript')] string $code): mixed
    {
        return $this->requests->send($code);
    }

    /**
     * Go forward using current history.
     *
     * @api
     */
    public function forward(): void
    {
        $this->api->saucer_webview_forward($this->ptr);
    }

    /**
     * Go back using current history.
     *
     * @api
     */
    public function back(): void
    {
        $this->api->saucer_webview_back($this->ptr);
    }

    /**
     * Reload current layout.
     *
     * @api
     */
    public function reload(): void
    {
        $this->api->saucer_webview_reload($this->ptr);
    }
}
