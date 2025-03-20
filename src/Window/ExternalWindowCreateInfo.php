<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

use FFI\CData;
use Serafim\Boson\WebView\WebViewCreateInfo;

/**
 * Information (configuration) about creating window from existing
 */
final readonly class ExternalWindowCreateInfo extends WindowCreateInfo
{
    public function __construct(
        /**
         * Native handle of the window. The handle can be a:
         * - GtkWindow pointer (GTK)
         * - NSWindow pointer (Cocoa)
         * - HWND (Win32)
         */
        public CData $handle,
        WebViewCreateInfo $webview = new WebViewCreateInfo(),
    ) {
        parent::__construct($webview);
    }
}
