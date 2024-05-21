<?php

declare(strict_types=1);

namespace Local\WebView2;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\Property\ReadableBoolProperty;
use Local\Com\Property\ReadableStructProperty;
use Local\Com\Property\ReadableWideStringProperty;
use Local\Com\WideString;
use Local\Property\Attribute\MapGetter;
use Local\WebView2\Callback\AddedScriptToExecuteHandler;
use Local\WebView2\Callback\AddScriptToExecuteOnDocumentCreatedCompletedHandler;
use Local\WebView2\Callback\ExecuteScriptCompletedHandler;
use Local\WebView2\Handler\EventSubscription;
use Local\WebView2\Handler\NavigationCompletedEventArgs;
use Local\WebView2\Handler\NavigationCompletedEventHandler;
use Local\WebView2\Handler\NavigationStartingEventArgs;
use Local\WebView2\Handler\NavigationStartingEventHandler;
use Local\WebView2\Handler\WebMessageReceivedEventArgs;
use Local\WebView2\Handler\WebMessageReceivedEventHandler;
use Local\WebView2\Shared\IUnknown;
use React\Promise\Promise;

/**
 * @property-read ICoreWebView2Settings $settings
 * @property-read string $source
 * @property-read bool $canGoBack
 * @property-read bool $canGoForward
 */
#[MapStruct(name: 'ICoreWebView2', owned: false)]
final class ICoreWebView2 extends IUnknown
{
    /**
     * @var ReadableStructProperty<ICoreWebView2Settings>
     */
    protected readonly ReadableStructProperty $settingsProperty;
    protected readonly ReadableWideStringProperty $sourceProperty;
    protected readonly ReadableBoolProperty $canGoBackProperty;
    protected readonly ReadableBoolProperty $canGoForwardProperty;

    public function __construct(
        WebView2 $ffi,
        CData $cdata,
        public readonly ICoreWebView2Controller $host,
    ) {
        parent::__construct($ffi, $cdata);

        $this->canGoBackProperty = new ReadableBoolProperty($this, 'CanGoBack');
        $this->canGoForwardProperty = new ReadableBoolProperty($this, 'CanGoForward');
        $this->sourceProperty = new ReadableWideStringProperty($this, 'Source');
        $this->settingsProperty = new ReadableStructProperty(
            context: $this,
            name: 'Settings',
            struct: ICoreWebView2Settings::class,
            initializer: function (CData $struct): ICoreWebView2Settings {
                return new ICoreWebView2Settings($this->ffi, $struct, $this);
            },
        );
    }

    /**
     * The {@see ICoreWebView2Settings} object contains various modifiable settings for the running WebView.
     *
     * @api
     * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2#get_settings
     */
    #[MapGetter(name: 'settings')]
    public function getSettings(): ICoreWebView2Settings
    {
        return $this->settingsProperty->get();
    }

    /**
     * @api
     */
    #[MapGetter(name: 'source')]
    public function getSource(): string
    {
        return $this->sourceProperty->get();
    }

    /**
     * @api
     */
    #[MapGetter(name: 'canGoBack')]
    public function canGoBack(): bool
    {
        return $this->canGoBackProperty->get();
    }

    /**
     * @api
     */
    #[MapGetter(name: 'canGoForward')]
    public function canGoForward(): bool
    {
        return $this->canGoForwardProperty->get();
    }

    /**
     * @api
     * @param callable(NavigationStartingEventArgs):void $then
     */
    public function onNavigationStarting(callable $then): EventSubscription
    {
        return $this->addEventListener(
            name: 'NavigationStarting',
            class: NavigationStartingEventHandler::class,
            then: $then,
        );
    }

    /**
     * @api
     * @param callable(NavigationCompletedEventArgs):void $then
     */
    public function onNavigationCompleted(callable $then): EventSubscription
    {
        return $this->addEventListener(
            name: 'NavigationCompleted',
            class: NavigationCompletedEventHandler::class,
            then: $then,
        );
    }

    /**
     * @api
     * @param callable(NavigationStartingEventArgs):void $then
     */
    public function onFrameNavigationStarting(callable $then): EventSubscription
    {
        return $this->addEventListener(
            name: 'FrameNavigationStarting',
            class: NavigationStartingEventHandler::class,
            then: $then,
        );
    }

    /**
     * @api
     * @param callable(NavigationCompletedEventArgs):void $then
     */
    public function onFrameNavigationCompleted(callable $then): EventSubscription
    {
        return $this->addEventListener(
            name: 'FrameNavigationCompleted',
            class: NavigationCompletedEventHandler::class,
            then: $then,
        );
    }

    /**
     * @api
     * @param callable(WebMessageReceivedEventArgs):void $then
     */
    public function onWebMessageReceived(callable $then): EventSubscription
    {
        return $this->addEventListener(
            name: 'WebMessageReceived',
            class: WebMessageReceivedEventHandler::class,
            then: $then,
        );
    }

    /**
     * @api
     * @return Promise<AddedScriptToExecuteHandler>
     */
    public function addScriptToExecuteOnDocumentCreated(string $code): Promise
    {
        return new Promise(function ($resolve) use ($code) {
            $handler = AddScriptToExecuteOnDocumentCreatedCompletedHandler::create(
                ffi: $this->ffi,
                callback: static function (string $id) use ($resolve): void {
                    $resolve(new AddedScriptToExecuteHandler($id));
                },
            );

            $this->call('AddScriptToExecuteOnDocumentCreated', [
                WideString::toWideString($code),
                \FFI::addr($handler->cdata),
            ]);
        });
    }

    /**
     * @api
     */
    public function removeScriptToExecuteOnDocumentCreated(AddedScriptToExecuteHandler $handler): void
    {
        $this->call('RemoveScriptToExecuteOnDocumentCreated', [
            $handler->id,
        ]);
    }

    /**
     * @api
     */
    public function executeScript(string $code): void
    {
        $handler = ExecuteScriptCompletedHandler::create($this->ffi);

        $this->call('ExecuteScript', [
            WideString::toWideString($code),
            \FFI::addr($handler->cdata),
        ]);
    }

    /**
     * @api
     */
    public function navigate(string $uri): void
    {
        $this->call('Navigate', [
            WideString::toWideString($uri),
        ]);
    }

    /**
     * @api
     */
    public function navigateToString(string $content): void
    {
        $this->call('NavigateToString', [
            WideString::toWideString($content),
        ]);
    }

    /**
     * @api
     */
    public function reload(): void
    {
        $this->call('Reload');
    }

    /**
     * @api
     */
    public function stop(): void
    {
        $this->call('Stop');
    }

    /**
     * @api
     */
    public function goBack(): void
    {
        $this->call('GoBack');
    }

    /**
     * @api
     */
    public function goForward(): void
    {
        $this->call('GoForward');
    }

    /**
     * @param array<array-key, mixed>|object $data
     * @throws \JsonException
     * @api
     */
    public function postWebMessage(array|object $data): void
    {
        $json = \json_encode($data, \JSON_THROW_ON_ERROR);

        $this->call('PostWebMessageAsJson', [
            WideString::toWideString($json),
        ]);
    }
}
