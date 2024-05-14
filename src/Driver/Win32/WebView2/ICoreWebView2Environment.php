<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Handle\Win32WindowHandle;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;
use Serafim\WinUI\Driver\Win32\Managed\LocalManaged;
use Serafim\WinUI\Driver\Win32\Text;
use Serafim\WinUI\Property\Property;
use Serafim\WinUI\Property\PropertyProviderTrait;

/**
 * @property-read string $browserVersionString
 *
 * @template-extends LocalManaged<WebView2>
 */
final class ICoreWebView2Environment extends LocalManaged
{
    use PropertyProviderTrait;

    /**
     * @return Property<string, never>
     */
    protected function browserVersionString(): Property
    {
        return Property::getter(function (): string {
            return Text::fromWide(
                text: $this->getManagedPropertyValue('BrowserVersionString', 'LPWSTR'),
                encoding: 'UTF-16BE',
            );
        });
    }

    /**
     * @param callable(ICoreWebView2Controller):void $then
     */
    public function createCoreWebView2Controller(Win32WindowHandle $handle, callable $then): int
    {
        $handler = new ControllerCompletedHandler(function (CData $host) use ($then): int {
            $then(new ICoreWebView2Controller(
                ffi: $this->ffi,
                ptr: $host,
                env: $this,
            ));

            return 0;
        });

        return ($this->ptr->lpVtbl->CreateCoreWebView2Controller)(
            $this->ptr,
            $this->ffi->cast('HWND', $handle->ptr),
            \FFI::addr($handler->get($this->ffi)),
        );
    }
}
