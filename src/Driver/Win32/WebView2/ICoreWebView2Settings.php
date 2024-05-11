<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;
use Serafim\WinUI\Driver\Win32\Managed\LocalCreated;
use Serafim\WinUI\Driver\Win32\Managed\ManagedStruct;

#[ManagedStruct(name: 'ICoreWebView2Settings')]
final class ICoreWebView2Settings extends LocalCreated
{
    private readonly WebView2 $webview2;

    public function __construct(
        CData $ptr,
        public readonly ICoreWebView2 $core,
        ?WebView2 $webview2 = null,
    ) {
        parent::__construct($ptr);

        $this->webview2 = $webview2 ?? WebView2::getInstance();
    }
}
