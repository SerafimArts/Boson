<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;
use Serafim\WinUI\Driver\Win32\WebView2\ICoreWebView2Controller;
use Serafim\WinUI\Window\WebViewInterface;

final class Win32WebView implements WebViewInterface
{
    private readonly WebView2 $api;

    public function __construct(
        private readonly Win32Window $window,
        private readonly ICoreWebView2Controller $host,
        private readonly CData $ptr,
        ?WebView2 $api = null,
    ) {
        $this->api = $api ?? WebView2::getInstance();
    }
}
