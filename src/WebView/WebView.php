<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use FFI\CData;
use JetBrains\PhpStorm\Language;
use Psr\EventDispatcher\EventDispatcherInterface;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Shared\Saucer\SaucerWebEvent;
use Serafim\Boson\WebView\Uri\MemoizedUriParser;
use Serafim\Boson\WebView\Uri\Uri;
use Serafim\Boson\Shared\Saucer\LibSaucer;
use Serafim\Boson\WebView\Uri\NativeUriParser;
use Serafim\Boson\WebView\Uri\UriParserInterface;
use Serafim\Boson\Window\Window;

final class WebView implements WebViewInterface
{
    private const string CALLBACKS_STRUCT = <<<'CDATA'
         struct {
             void (*onDomReady)(const saucer_handle *);
             void (*onNavigated)(const saucer_handle *, const char *);
             void (*onNavigate)(const saucer_handle *, const saucer_navigation *);
             void (*onFaviconChanged)(const saucer_handle *, const saucer_icon *);
             void (*onTitleChanged)(const saucer_handle *, const char *);
             void (*onLoad)(const saucer_handle *, const SAUCER_STATE *);
         }
         CDATA;

    /**
     * Contains managed struct that contain list of event listeners.
     */
    private readonly CData $callbacks;

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

    private readonly DelegateEventListener $events;

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

        $this->createEventListener();
    }

    /**
     * @param SaucerWebEvent::SAUCER_WEB_EVENT_* $event
     */
    private function listen(int $event, CData $callback): void
    {
        $this->api->saucer_webview_on($this->ptr, $event, $callback);
    }

    private function onDomReady(mixed $ptr): void
    {
        // dump(__FUNCTION__);
    }

    private function onNavigated(mixed $ptr, string $url): void
    {
        // dump(__FUNCTION__ . ' -> ' . $url);
    }

    private function onNavigate(mixed $ptr, mixed $navigation): void
    {
        // dump(__FUNCTION__ . ' -> ' . \FFI::string($this->api->saucer_navigation_url($navigation)));
    }

    private function onFaviconChanged(mixed $ptr, mixed $icon): void
    {
        $this->api->saucer_window_set_icon($ptr, $icon);
        // dump(__FUNCTION__);
    }

    private function onTitleChanged(mixed $ptr, string $title): void
    {
        $this->api->saucer_window_set_title($ptr, $title);
        // dump(__FUNCTION__ . ' -> ' . $title);
    }

    private function onLoad(mixed $ptr, CData $state): void
    {
        // dump(__FUNCTION__ . ' -> ' . $state[0]);
    }

    private function createEventListener(): CData
    {
        $struct = $this->api->new(self::CALLBACKS_STRUCT);
        $struct->onDomReady = $this->onDomReady(...);
        $struct->onNavigated = $this->onNavigated(...);
        $struct->onNavigate = $this->onNavigate(...);
        $struct->onFaviconChanged = $this->onFaviconChanged(...);
        $struct->onTitleChanged = $this->onTitleChanged(...);
        $struct->onLoad = $this->onLoad(...);

        $this->listen(SaucerWebEvent::SAUCER_WEB_EVENT_DOM_READY, $struct->onDomReady);
        $this->listen(SaucerWebEvent::SAUCER_WEB_EVENT_NAVIGATED, $struct->onNavigated);
        $this->listen(SaucerWebEvent::SAUCER_WEB_EVENT_NAVIGATE, $struct->onNavigate);
        $this->listen(SaucerWebEvent::SAUCER_WEB_EVENT_FAVICON, $struct->onFaviconChanged);
        $this->listen(SaucerWebEvent::SAUCER_WEB_EVENT_TITLE, $struct->onTitleChanged);
        $this->listen(SaucerWebEvent::SAUCER_WEB_EVENT_LOAD, $struct->onLoad);

        return $struct;
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
