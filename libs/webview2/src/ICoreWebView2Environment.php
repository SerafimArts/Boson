<?php

declare(strict_types=1);

namespace Local\WebView2;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\IUnknown;
use Local\Com\Property\ReadableWideStringProperty;
use Local\Property\Attribute\MapGetter;
use Local\WebView2\Handler\CreateCoreWebView2ControllerCompletedHandler;

/**
 * @template-extends IUnknown<WebView2>
 *
 * @property-read string $browserVersionString
 * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2environment
 */
#[MapStruct(name: 'ICoreWebView2Environment')]
final class ICoreWebView2Environment extends IUnknown
{
    private readonly ReadableWideStringProperty $browserVersionStringProperty;

    public function __construct(WebView2 $ffi, CData $cdata)
    {
        parent::__construct($ffi, $cdata);

        $this->browserVersionStringProperty = new ReadableWideStringProperty($this, 'BrowserVersionString');
    }

    /**
     * Asynchronously create a new WebView.
     *
     * The parent window is the HWND ({@see $window} param) in which the WebView
     * should be displayed and from which receive input. The WebView adds a
     * child window to the provided window before this function returns. Z-order
     * and other things impacted by sibling window order are affected accordingly.
     *
     * @api
     * @param callable(ICoreWebView2Controller):void $then
     * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2environment#createcorewebview2controller
     */
    public function createCoreWebView2Controller(CData $window, callable $then): int
    {
        $handler = CreateCoreWebView2ControllerCompletedHandler::create(
            ffi: $this->ffi,
            callback: function (CData $host) use ($then): void {
                $then(new ICoreWebView2Controller($this->ffi, $host, $this));
            },
        );

        return ($this->vt->CreateCoreWebView2Controller)(
            $this->cdata,
            $this->ffi->cast('HWND', $window),
            \FFI::addr($handler->cdata),
        );
    }

    /**
     * The browser version info of the current {@see ICoreWebView2Environment},
     * including channel name if it is not the WebView2 Runtime.
     *
     * @api
     * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2environment#get_browserversionstring
     */
    #[MapGetter(name: 'browserVersionString')]
    public function getBrowserVersionString(): string
    {
        return $this->browserVersionStringProperty->get();
    }
}
