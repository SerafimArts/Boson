<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use Serafim\Boson\Dispatcher\EventListenerInterface;
use Serafim\Boson\WebView\Binding\FunctionsMapInterface;
use Serafim\Boson\WebView\Scripts\ScriptsMapInterface;
use Serafim\Boson\WebView\Url\Url;
use Serafim\Boson\Window\WindowInterface;

interface WebViewInterface
{
    /**
     * Gets information DTO about the webview with which it was created.
     */
    public WebViewCreateInfo $info { get; }

    /**
     * Gets parent application window instance to which this webview instance belongs.
     */
    public WindowInterface $window { get; }

    /**
     * Gets access to the listener of the webview events
     * and intention subscriptions.
     */
    public EventListenerInterface $events { get; }

    /**
     * Gets access to the scripts list of the webview.
     */
    public ScriptsMapInterface $scripts { get; }

    /**
     * Gets access to the functions list of the webview.
     */
    public FunctionsMapInterface $functions { get; }

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
