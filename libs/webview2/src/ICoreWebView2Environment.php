<?php

declare(strict_types=1);

namespace Local\WebView2;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\Exception\ResultException;
use Local\Com\Property\ReadableWideStringProperty;
use Local\Property\Attribute\MapGetter;
use Local\WebView2\Callback\CreateCoreWebView2ControllerCompletedHandler;
use React\Promise\Promise;
use Local\WebView2\Shared\IUnknown;

/**
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
     * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2environment#createcorewebview2controller
     * @return Promise<ICoreWebView2Controller>
     */
    public function createCoreWebView2Controller(CData $window): Promise
    {
        /** @var Promise<ICoreWebView2Controller> */
        return new Promise(function (callable $resolve) use ($window): void {
            $handler = CreateCoreWebView2ControllerCompletedHandler::create(
                ffi: $this->ffi,
                callback: function (CData $host) use ($resolve): void {
                    $resolve(new ICoreWebView2Controller($this->ffi, $host, $this));
                },
            );

            $this->call('CreateCoreWebView2Controller', [
                $this->ffi->cast('HWND', $window),
                \FFI::addr($handler->cdata),
            ]);
        });
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
