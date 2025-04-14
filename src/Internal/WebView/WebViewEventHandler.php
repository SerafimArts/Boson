<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal\WebView;

use FFI\CData;
use Serafim\Boson\Dispatcher\EventDispatcherInterface;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Internal\Saucer\SaucerPolicy;
use Serafim\Boson\Internal\Saucer\SaucerState;
use Serafim\Boson\Internal\Saucer\SaucerWebEvent as Event;
use Serafim\Boson\WebView\Event\WebViewDomReady;
use Serafim\Boson\WebView\Event\WebViewFaviconChanged;
use Serafim\Boson\WebView\Event\WebViewFaviconChanging;
use Serafim\Boson\WebView\Event\WebViewLoaded;
use Serafim\Boson\WebView\Event\WebViewLoading;
use Serafim\Boson\WebView\Event\WebViewNavigated;
use Serafim\Boson\WebView\Event\WebViewNavigating;
use Serafim\Boson\WebView\Event\WebViewTitleChanged;
use Serafim\Boson\WebView\Event\WebViewTitleChanging;
use Serafim\Boson\WebView\State;
use Serafim\Boson\WebView\Uri\UriParserInterface;
use Serafim\Boson\WebView\WebView;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson\WebView
 */
final class WebViewEventHandler
{
    /**
     * @var non-empty-string
     */
    private const string HANDLER_STRUCT = <<<'CDATA'
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
     * Contains managed struct with event handlers.
     */
    private readonly CData $handlers;

    public function __construct(
        private readonly LibSaucer $api,
        private readonly WebView $webView,
        private readonly EventDispatcherInterface $dispatcher,
        private readonly UriParserInterface $uriParser,
        private State &$state,
    ) {
        $this->handlers = $this->createEventHandlers();

        $this->listenEvents();
    }

    private function changeState(State $state): void
    {
        $this->state = $state;
    }

    private function createEventHandlers(): CData
    {
        $struct = $this->api->new(self::HANDLER_STRUCT);

        $struct->onDomReady = $this->onDomReady(...);
        $struct->onNavigated = $this->onNavigated(...);
        $struct->onNavigating = $this->onNavigating(...);
        $struct->onFaviconChanged = $this->onFaviconChanged(...);
        $struct->onTitleChanged = $this->onTitleChanged(...);
        $struct->onLoad = $this->onLoad(...);

        return $struct;
    }

    public function listenEvents(): void
    {
        $ptr = $this->webView->window->id->ptr;

        $this->api->saucer_webview_on($ptr, Event::SAUCER_WEB_EVENT_DOM_READY, $this->handlers->onDomReady);
        $this->api->saucer_webview_on($ptr, Event::SAUCER_WEB_EVENT_NAVIGATED, $this->handlers->onNavigated);
        $this->api->saucer_webview_on($ptr, Event::SAUCER_WEB_EVENT_NAVIGATE, $this->handlers->onNavigating);
        $this->api->saucer_webview_on($ptr, Event::SAUCER_WEB_EVENT_FAVICON, $this->handlers->onFaviconChanged);
        $this->api->saucer_webview_on($ptr, Event::SAUCER_WEB_EVENT_TITLE, $this->handlers->onTitleChanged);
        $this->api->saucer_webview_on($ptr, Event::SAUCER_WEB_EVENT_LOAD, $this->handlers->onLoad);
    }

    private function onDomReady(CData $_): void
    {
        $this->dispatcher->dispatch(new WebViewDomReady(
            subject: $this->webView,
        ));
    }

    private function onNavigated(CData $_, string $url): void
    {
        $this->dispatcher->dispatch(new WebViewNavigated(
            subject: $this->webView,
            uri: $this->uriParser->parse($url),
        ));
    }

    private function onNavigating(CData $_, CData $navigation): int
    {
        $this->changeState(State::Navigating);

        $uri = $this->uriParser->parse(
            uri: \FFI::string($this->api->saucer_navigation_url($navigation)),
        );

        $intention = $this->dispatcher->dispatch(new WebViewNavigating(
            subject: $this->webView,
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
        $intention = $this->dispatcher->dispatch(new WebViewFaviconChanging($this->webView));

        try {
            if ($intention->isCancelled) {
                return;
            }

            $this->api->saucer_window_set_icon($ptr, $icon);
            $this->dispatcher->dispatch(new WebViewFaviconChanged($this->webView));
        } finally {
            $this->api->saucer_icon_free($icon);
        }
    }

    private function onTitleChanged(CData $ptr, string $title): void
    {
        $intention = $this->dispatcher->dispatch(new WebViewTitleChanging(
            subject: $this->webView,
            title: $title,
        ));

        if ($intention->isCancelled) {
            return;
        }

        $this->api->saucer_window_set_title($ptr, $title);
        $this->dispatcher->dispatch(new WebViewTitleChanged($this->webView, $title));
    }

    private function onLoad(CData $_, CData $state): void
    {
        if ($state[0] === SaucerState::SAUCER_STATE_STARTED) {
            $this->changeState(State::Loading);
            $this->dispatcher->dispatch(new WebViewLoading($this->webView));

            return;
        }

        $this->changeState(State::Ready);
        $this->dispatcher->dispatch(new WebViewLoaded($this->webView));
    }
}
