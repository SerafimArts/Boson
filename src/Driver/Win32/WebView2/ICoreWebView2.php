<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;
use Serafim\WinUI\Driver\Win32\Managed\LocalCreated;
use Serafim\WinUI\Driver\Win32\Managed\ManagedStruct;

#[ManagedStruct(name: 'ICoreWebView2')]
final class ICoreWebView2 extends LocalCreated
{
    private readonly WebView2 $webview2;

    public function __construct(
        CData $ptr,
        public readonly ICoreWebView2Controller $host,
        ?WebView2 $webview2 = null,
    ) {
        parent::__construct($ptr);

        $this->webview2 = $webview2 ?? WebView2::getInstance();
    }

    public function getSettings(): ICoreWebView2Settings
    {
        $settings = ICoreWebView2Settings::allocate($this->webview2);

        $result = $this->get_Settings(\FFI::addr($settings));

        if ($result !== 0) {
            throw new \RuntimeException('Could not get WebView settings');
        }

        return new ICoreWebView2Settings(
            ptr: $settings,
            core: $this,
            webview2: $this->webview2,
        );
    }
}
