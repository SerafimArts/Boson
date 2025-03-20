<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use FFI\CData;
use JetBrains\PhpStorm\Language;
use React\Promise\PromiseInterface;
use Serafim\Boson\Core\WebView\WebViewError;
use Serafim\Boson\Core\WebView\WebViewLibrary;
use Serafim\Boson\Exception\WebViewException;
use Serafim\Boson\Exception\WebViewInternalException;
use Serafim\Boson\WebView\Binding\WebViewFrozenFunctionsMap;
use Serafim\Boson\WebView\Binding\WebViewFunctionsMap;
use Serafim\Boson\WebView\Binding\WebViewFunctionsMapInterface;
use Serafim\Boson\WebView\Requests\WebViewRequests;
use Serafim\Boson\WebView\Requests\WebViewRequestsInterface;
use Serafim\Boson\WebView\Scripts\WebViewFrozenScriptsMap;
use Serafim\Boson\WebView\Scripts\WebViewScriptsMap;
use Serafim\Boson\WebView\Scripts\WebViewScriptsMapInterface;
use Serafim\Boson\WebView\Styles\WebViewFrozenStylesMap;
use Serafim\Boson\WebView\Styles\WebViewStylesMap;
use Serafim\Boson\WebView\Styles\WebViewStylesMapInterface;

final class WebView
{
    /**
     * Load HTML content into the WebView
     */
    public string $html {
        set(string $html) {
            $result = $this->api->webview_set_html($this->webview, $html);

            if ($result !== WebViewError::WEBVIEW_ERROR_OK) {
                throw WebViewInternalException::becauseErrorOccurs('loading HTML', $result);
            }
        }
    }

    /**
     * Navigates WebView to the given URL.
     *
     * URL may be a properly encoded data URI:
     *
     * ```
     * $webview->url = 'https://github.com/webview/webview';
     * $webview->url = 'data:text/html,%3Ch1%3EHello%3C%2Fh1%3E';
     * $webview->url = 'data:text/html;base64,PGgxPkhlbGxvPC9oMT4=';
     * ```
     */
    public string $url {
        set(string $url) {
            $result = $this->api->webview_navigate($this->webview, $url);

            if ($result !== WebViewError::WEBVIEW_ERROR_OK) {
                throw WebViewInternalException::becauseErrorOccurs('navigation to URL', $result);
            }
        }
    }

    /**
     * Contains a list of registered functions
     *
     * @var WebViewFunctionsMapInterface<\Closure>
     */
    public private(set) WebViewFunctionsMapInterface $functions;

    /**
     * Contains a list of registered initialization scripts
     */
    public private(set) WebViewScriptsMapInterface $scripts;

    /**
     * Contains a list of registered initialization styles
     */
    public private(set) WebViewStylesMapInterface $styles;

    /**
     * Contains API for receiving data from the client
     */
    public readonly WebViewRequests $requests;

    public function __construct(
        /**
         * An API library for working with WebView
         */
        private readonly WebViewLibrary $api,
        /**
         * Pointer to WebView structure
         */
        private readonly CData $webview,
        /**
         * WebView creation info DTO
         */
        public readonly WebViewCreateInfo $info = new WebViewCreateInfo(),
    ) {
        $this->functions = new WebViewFunctionsMap($this->api, $this->webview);
        $this->scripts = new WebViewScriptsMap();
        $this->styles = new WebViewStylesMap();
        $this->requests = new WebViewRequests($this);
    }

    /**
     * You really don't need this
     *
     * @api
     *
     * @param callable():void $callback
     */
    public function dispatch(callable $callback): void
    {
        $result = $this->api->webview_dispatch($this->webview, $callback, null);

        if ($result !== WebViewError::WEBVIEW_ERROR_OK) {
            throw WebViewInternalException::becauseErrorOccurs('dispatching callback', $result);
        }
    }

    /**
     * Facade method of {@see WebViewRequestsInterface::send()}
     *
     * @api
     *
     * @return PromiseInterface<mixed>
     */
    public function request(#[Language('JavaScript')] string $code): PromiseInterface
    {
        return $this->requests->send($code);
    }

    /**
     * Facade method of {@see WebViewScriptsMapInterface::add()}
     *
     * @api
     *
     * @param non-empty-string $code An initialization JavaScript code
     *
     * @return array-key Returns code identifier
     */
    public function evalBeforeLoad(#[Language('JavaScript')] string $code): int|string
    {
        return $this->scripts->add($code);
    }

    /**
     * Facade method of {@see WebViewStylesMapInterface::add()}
     *
     * @api
     *
     * @param non-empty-string $style An initialization CSS styles
     *
     * @return array-key Returns code identifier
     */
    public function styleBeforeLoad(#[Language('CSS')] string $style): int|string
    {
        return $this->styles->add($style);
    }

    /**
     * Binds an function to a new global JavaScript function
     *
     * @api
     *
     * @param non-empty-string $function
     *
     * @throws WebViewException in case of function binding error
     */
    public function bind(string $function, callable $callback): void
    {
        $this->functions->add($function, $callback(...));
    }

    /**
     * Evaluates arbitrary JavaScript code
     *
     * Use {@see WebView::bind()} bindings if you need to communicate
     * the result of the evaluation
     *
     * @api
     */
    public function eval(#[Language('JavaScript')] string $code): void
    {
        $result = $this->api->webview_eval($this->webview, $code);

        if ($result !== WebViewError::WEBVIEW_ERROR_OK) {
            throw WebViewInternalException::becauseErrorOccurs('evaluating JavaScript', $result);
        }
    }

    /**
     * @internal
     */
    public function run(): void
    {
        // Load initialization script (after navigation)
        $result = $this->api->webview_init($this->webview, \vsprintf("%s\n%s", [
            (string) $this->styles,
            (string) $this->scripts,
        ]));

        if ($result !== WebViewError::WEBVIEW_ERROR_OK) {
            throw WebViewInternalException::becauseErrorOccurs('setting init CSS and JavaScript', $result);
        }

        // Apply styles on current HTML
        $this->eval(\vsprintf("%s\n%s", [
            (string) $this->styles,
            (string) $this->scripts,
        ]));

        // Execute an application
        $result = $this->api->webview_run($this->webview);

        if ($result !== WebViewError::WEBVIEW_ERROR_OK) {
            throw WebViewInternalException::becauseErrorOccurs('running WebView', $result);
        }

        // Freeze functions list
        if ($this->functions instanceof WebViewFunctionsMap) {
            $this->functions = new WebViewFrozenFunctionsMap($this->functions);
        }

        // Freeze code list
        if ($this->scripts instanceof WebViewScriptsMap) {
            $this->scripts = new WebViewFrozenScriptsMap($this->scripts);
        }

        // Freeze styles list
        if ($this->styles instanceof WebViewStylesMap) {
            $this->styles = new WebViewFrozenStylesMap($this->styles);
        }
    }
}
