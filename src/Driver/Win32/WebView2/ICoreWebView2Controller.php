<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;
use Serafim\WinUI\Driver\Win32\Managed\LocalManaged;

final class ICoreWebView2Controller extends LocalManaged
{
    private readonly WebView2 $webView2;

    public function __construct(
        CData $ptr,
        public readonly ICoreWebView2Environment $env,
        ?WebView2 $webView2 = null,
    ) {
        parent::__construct($ptr);

        $this->webView2 = $webView2 ?? WebView2::getInstance();
    }
}
