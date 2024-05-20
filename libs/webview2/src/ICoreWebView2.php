<?php

declare(strict_types=1);

namespace Local\WebView2;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\IUnknown;
use Local\Com\Property\ReadableStructProperty;
use Local\Com\Property\ReadableWideStringProperty;
use Local\Com\WideString;
use Local\Property\Attribute\MapGetter;
use Local\WebView2\Handler\EventSubscription;
use Local\WebView2\Handler\NavigationCompletedEventArgs;
use Local\WebView2\Handler\NavigationCompletedEventHandler;
use Local\WebView2\Handler\NavigationStartingEventArgs;
use Local\WebView2\Handler\NavigationStartingEventHandler;

/**
 * @template-extends IUnknown<WebView2>
 *
 * @property-read ICoreWebView2Settings $settings
 */
#[MapStruct(name: 'ICoreWebView2', owned: false)]
final class ICoreWebView2 extends IUnknown
{
    /**
     * @var ReadableStructProperty<ICoreWebView2Settings>
     */
    protected readonly ReadableStructProperty $settingsProperty;

    protected readonly ReadableWideStringProperty $sourceProperty;

    /**
     * @var list<EventSubscription>
     */
    private array $listeners = [];

    public function __construct(
        WebView2 $ffi,
        CData $cdata,
        public readonly ICoreWebView2Controller $host,
    ) {
        parent::__construct($ffi, $cdata);

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
     * @param callable(NavigationStartingEventArgs):void $then
     */
    public function onNavigationStarting(callable $then): EventSubscription
    {
        return $this->listeners[] = NavigationStartingEventHandler::create($this->ffi, $then)
            ->listen($this, 'NavigationStarting');
    }

    /**
     * @api
     * @param callable(NavigationCompletedEventArgs):void $then
     */
    public function onNavigationCompleted(callable $then): EventSubscription
    {
        return $this->listeners[] = NavigationCompletedEventHandler::create($this->ffi, $then)
            ->listen($this, 'NavigationCompleted');
    }

    /**
     * @api
     * @param callable(NavigationStartingEventArgs):void $then
     */
    public function onFrameNavigationStarting(callable $then): EventSubscription
    {
        return $this->listeners[] = NavigationStartingEventHandler::create($this->ffi, $then)
            ->listen($this, 'FrameNavigationStarting');
    }

    /**
     * @api
     * @param callable(NavigationCompletedEventArgs):void $then
     */
    public function onFrameNavigationCompleted(callable $then): EventSubscription
    {
        return $this->listeners[] = NavigationCompletedEventHandler::create($this->ffi, $then)
            ->listen($this, 'FrameNavigationCompleted');
    }

    /**
     * @api
     */
    public function navigate(string $uri): void
    {
        ($this->vt->Navigate)($this->cdata, WideString::toWideString($uri));
    }

    /**
     * @api
     */
    public function reload(): void
    {
        ($this->vt->Reload)($this->cdata);
    }

    public function __destruct()
    {
        foreach ($this->listeners as $listener) {
            $listener->cancel();
        }

        $this->listeners = [];
    }
}
