<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use FFI\CData;
use JetBrains\PhpStorm\Language;
use Psr\EventDispatcher\EventDispatcherInterface;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Shared\Saucer\LibSaucer;
use Serafim\Boson\Shared\Saucer\SaucerPolicy;
use Serafim\Boson\Shared\Saucer\SaucerState;
use Serafim\Boson\Shared\Saucer\SaucerWebEvent;
use Serafim\Boson\WebView\Event\WebViewDomReady;
use Serafim\Boson\WebView\Event\WebViewFaviconChanged;
use Serafim\Boson\WebView\Event\WebViewFaviconChanging;
use Serafim\Boson\WebView\Event\WebViewLoaded;
use Serafim\Boson\WebView\Event\WebViewLoading;
use Serafim\Boson\WebView\Event\WebViewNavigated;
use Serafim\Boson\WebView\Event\WebViewNavigating;
use Serafim\Boson\WebView\Event\WebViewTitleChanged;
use Serafim\Boson\WebView\Event\WebViewTitleChanging;
use Serafim\Boson\WebView\Uri\MemoizedUriParser;
use Serafim\Boson\WebView\Uri\NativeUriParser;
use Serafim\Boson\WebView\Uri\Uri;
use Serafim\Boson\WebView\Uri\UriParserInterface;
use Serafim\Boson\Window\Window;

final class WebView implements WebViewInterface
{
    private const string CALLBACKS_STRUCT = <<<'CDATA'
         struct {
             void (*onDomReady)(const saucer_handle *);
             void (*onNavigated)(const saucer_handle *, const char *);
             SAUCER_POLICY (*onNavigating)(const saucer_handle *, const saucer_navigation *);
             void (*onFaviconChanged)(const saucer_handle *, const saucer_icon *);
             void (*onTitleChanged)(const saucer_handle *, const char *);
             void (*onLoad)(const saucer_handle *, const SAUCER_STATE *);
         }
         CDATA;

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

    /**
     * @var State
     */
    public private(set) State $state = State::Loading;

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

        $this->createEventListener();
    }

    private function onDomReady(CData $_): void
    {
        $this->events->dispatch(new WebViewDomReady($this));
    }

    private function onNavigated(CData $_, string $url): void
    {
        $this->events->dispatch(new WebViewNavigated($this, $this->uriParser->parse($url)));
    }

    private function onNavigating(CData $_, CData $navigation): int
    {
        $this->state = State::Navigating;

        $uri = $this->uriParser->parse(
            uri: \FFI::string($this->api->saucer_navigation_url($navigation)),
        );

        $intention = $this->events->dispatch(new WebViewNavigating(
            subject: $this,
            uri: $uri,
            isNewWindow: $this->api->saucer_navigation_new_window($navigation),
            isRedirection: $this->api->saucer_navigation_redirection($navigation),
            isUserInitiated: $this->api->saucer_navigation_user_initiated($navigation),
        ));

        $this->api->saucer_navigation_free($navigation);

        return $intention->isCancelled
            ? SaucerPolicy::SAUCER_POLICY_BLOCK
            : SaucerPolicy::SAUCER_POLICY_ALLOW;
    }

    private function onFaviconChanged(CData $ptr, CData $icon): void
    {
        $intention = $this->events->dispatch(new WebViewFaviconChanging($this));

        try {
            if ($intention->isCancelled) {
                return;
            }

            $this->api->saucer_window_set_icon($ptr, $icon);
            $this->events->dispatch(new WebViewFaviconChanged($this));
        } finally {
            $this->api->saucer_icon_free($icon);
        }
    }

    private function onTitleChanged(CData $ptr, string $title): void
    {
        $intention = $this->events->dispatch(new WebViewTitleChanging($this, $title));

        if ($intention->isCancelled) {
            return;
        }

        $this->api->saucer_window_set_title($ptr, $title);
        $this->events->dispatch(new WebViewTitleChanged($this, $title));
    }

    private function onLoad(CData $_, CData $state): void
    {
        if ($state[0] === SaucerState::SAUCER_STATE_STARTED) {
            $this->state = State::Loading;
            $this->events->dispatch(new WebViewLoading($this));
            return;
        }

        $this->state = State::Ready;
        $this->events->dispatch(new WebViewLoaded($this));
    }

    private function createEventListener(): void
    {
        $struct = $this->api->new(self::CALLBACKS_STRUCT);
        $struct->onDomReady = $this->onDomReady(...);
        $struct->onNavigated = $this->onNavigated(...);
        $struct->onNavigating = $this->onNavigating(...);
        $struct->onFaviconChanged = $this->onFaviconChanged(...);
        $struct->onTitleChanged = $this->onTitleChanged(...);
        $struct->onLoad = $this->onLoad(...);

        $this->api->saucer_webview_on($this->ptr, SaucerWebEvent::SAUCER_WEB_EVENT_DOM_READY, $struct->onDomReady);
        $this->api->saucer_webview_on($this->ptr, SaucerWebEvent::SAUCER_WEB_EVENT_NAVIGATED, $struct->onNavigated);
        $this->api->saucer_webview_on($this->ptr, SaucerWebEvent::SAUCER_WEB_EVENT_NAVIGATE, $struct->onNavigating);
        $this->api->saucer_webview_on($this->ptr, SaucerWebEvent::SAUCER_WEB_EVENT_FAVICON, $struct->onFaviconChanged);
        $this->api->saucer_webview_on($this->ptr, SaucerWebEvent::SAUCER_WEB_EVENT_TITLE, $struct->onTitleChanged);
        $this->api->saucer_webview_on($this->ptr, SaucerWebEvent::SAUCER_WEB_EVENT_LOAD, $struct->onLoad);
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
