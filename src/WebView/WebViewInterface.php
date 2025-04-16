<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use JetBrains\PhpStorm\Language;
use Serafim\Boson\Dispatcher\EventListenerProviderInterface;
use Serafim\Boson\WebView\Binding\Exception\FunctionAlreadyDefinedException;
use Serafim\Boson\WebView\Binding\WebViewFunctionsMapInterface;
use Serafim\Boson\WebView\Requests\WebViewRequestsInterface;
use Serafim\Boson\WebView\Scripts\WebViewScriptsSetInterface;
use Serafim\Boson\WebView\Url\Url;
use Serafim\Boson\Window\WindowProviderInterface;

interface WebViewInterface extends
    EventListenerProviderInterface,
    WindowProviderInterface
{
    /**
     * Gets information DTO about the webview with which it was created.
     */
    public WebViewCreateInfo $info { get; }

    /**
     * Gets access to the scripts API of the webview.
     */
    public WebViewScriptsSetInterface $scripts { get; }

    /**
     * Gets access to the functions API of the webview.
     */
    public WebViewFunctionsMapInterface $functions { get; }

    /**
     * Gets access to the requests API of the webview.
     */
    public WebViewRequestsInterface $requests { get; }

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
        get;
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
        set(Url|\Stringable|string $url);
    }

    /**
     * Load HTML content into the WebView.
     */
    public string $html {
        set(string|\Stringable $html);
    }

    /**
     * Gets webview status.
     */
    public State $state { get; }

    /**
     * Binds an function to a new global JavaScript function.
     *
     * Note: This is facade method of the {@see WebViewFunctionsMapInterface::bind()},
     *       that provides by the {@see $functions} field. This means that
     *       calling `$webview->functions->bind(...)` should have the same effect.
     *
     * @param non-empty-string $function
     *
     * @throws FunctionAlreadyDefinedException in case of function binding error
     */
    public function bind(string $function, \Closure $callback): void;

    /**
     * Evaluates arbitrary JavaScript code.
     *
     * Note: This is facade method of the {@see WebViewScriptsSetInterface::eval()},
     *       that provides by the {@see $scripts} field. This means that
     *       calling `$webview->scripts->eval(...)` should have the same effect.
     *
     * @param string $code A JavaScript code for execution
     */
    public function eval(#[Language('JavaScript')] string $code): void;

    /**
     * Requests arbitrary data from webview using JavaScript code.
     *
     *  Note: This is facade method of the {@see WebViewRequestsInterface::send()},
     *        that provides by the {@see $requests} field. This means that
     *        calling `$webview->requests->send(...)` should have the same effect.
     */
    public function request(#[Language('JavaScript')] string $code): mixed;

    /**
     * Go forward using current history.
     */
    public function forward(): void;

    /**
     * Go back using current history.
     */
    public function back(): void;

    /**
     * Reload current layout.
     */
    public function reload(): void;
}
