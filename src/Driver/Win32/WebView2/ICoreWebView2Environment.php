<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Handle\Win32WindowHandle;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;
use Serafim\WinUI\Driver\Win32\Managed\LocalManaged;

final class ICoreWebView2Environment extends LocalManaged
{
    private readonly WebView2 $webView2;

    public function __construct(
        CData $ptr,
        ?WebView2 $webView2 = null,
    ) {
        parent::__construct($ptr);

        $this->webView2 = $webView2 ?? WebView2::getInstance();
    }

    /**
     * @param callable(ICoreWebView2Controller):void $then
     */
    public function createCoreWebView2Controller(Win32WindowHandle $handle, callable $then): int
    {
        $handler = new ControllerCompletedHandler(function (CData $host) use ($then): int {
            $then(new ICoreWebView2Controller(
                ptr: $host,
                env: $this,
                webView2: $this->webView2,
            ));

            return 0;
        });

        return ($this->ptr->lpVtbl->CreateCoreWebView2Controller)(
            $this->ptr,
            $this->webView2->cast('HWND', $handle->ptr),
            \FFI::addr($handler->get($this->webView2)),
        );
    }
}
