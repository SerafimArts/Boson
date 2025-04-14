<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use JetBrains\PhpStorm\Language;
use Serafim\Boson\Dispatcher\EventListenerInterface;
use Serafim\Boson\WebView\Uri\Uri;
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
     * Contains webview URI instance.
     */
    public Uri $uri {
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
        set(Uri|\Stringable|string $url);
    }

    /**
     * Gets webview status.
     */
    public State $state { get; }

    /**
     * Load WebView content from passed html string.
     */
    public function loadHtml(#[Language('HTML')] string $html): void;

    /**
     * Load WebView content from virtual filesystem.
     *
     * @param non-empty-string $name
     */
    public function loadFromVirtualFilesystem(string $name): void;

    /**
     * Load WebView content from local filesystem.
     *
     * @param non-empty-string $pathname
     */
    public function loadFromLocalFilesystem(string $pathname): void;

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
