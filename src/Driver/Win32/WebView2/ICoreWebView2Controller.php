<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;
use Serafim\WinUI\Driver\Win32\Managed\LocalManaged;
use Serafim\WinUI\Driver\Win32\Win32WebView;

final class ICoreWebView2Controller extends LocalManaged
{
    private readonly WebView2 $webview2;

    public function __construct(
        CData $ptr,
        public readonly ICoreWebView2Environment $env,
        ?WebView2 $webview2 = null,
    ) {
        parent::__construct($ptr);

        $this->webview2 = $webview2 ?? WebView2::getInstance();
    }

    public function getCoreWebView(): ICoreWebView2
    {
        $webview = ICoreWebView2::allocate($this->webview2);

        $result = $this->get_CoreWebView2(\FFI::addr($webview));

        if ($result !== 0) {
            throw new \RuntimeException('Could not get WebView core');
        }

        return new ICoreWebView2(
            ptr: $webview,
            host: $this,
            webview2: $this->webview2,
        );
    }
}
