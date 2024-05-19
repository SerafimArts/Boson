<?php

declare(strict_types=1);

namespace Local\WebView2;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\IUnknown;
use Local\Com\Property\ReadableStructProperty;
use Local\Com\WideString;
use Local\Property\Attribute\MapGetter;

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

    public function __construct(
        WebView2 $ffi,
        CData $cdata,
        public readonly ICoreWebView2Controller $host,
    ) {
        parent::__construct($ffi, $cdata);

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
    public function navigate(string $uri): void
    {
        ($this->vt->Navigate)($this->cdata, WideString::toWideString($uri));
    }
}
