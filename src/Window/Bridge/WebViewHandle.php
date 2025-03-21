<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Bridge;

use FFI\CData;
use Serafim\Boson\Window\HandleInterface;

final readonly class WebViewHandle implements HandleInterface
{
    public function __construct(
        public CData $webview,
        /**
         * Gets the native handle of the window associated with the webview
         * instance.
         *
         * The handle can be a:
         * - GtkWindow pointer (GTK)
         * - NSWindow pointer (Cocoa)
         * - HWND (Win32)
         */
        public CData $ptr,
    ) {}
}
