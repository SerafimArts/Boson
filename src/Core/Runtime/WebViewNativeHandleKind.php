<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Runtime;

/**
 * Native handle kind. The actual type depends on the backend.
 *
 * @internal this is an internal library class, please do not use it in your code.
 * @psalm-internal Serafim\Boson\Core
 */
final readonly class WebViewNativeHandleKind
{
    /**
     * Top-level window.
     *
     * - GtkWindow pointer (GTK)
     * - NSWindow pointer (Cocoa)
     * - HWND (Win32)
     */
    public const int WEBVIEW_NATIVE_HANDLE_KIND_UI_WINDOW = 0x00;

    /**
     * Browser widget.
     *
     * - GtkWidget pointer (GTK)
     * - NSView pointer (Cocoa)
     * - HWND (Win32)
     */
    public const int WEBVIEW_NATIVE_HANDLE_KIND_UI_WIDGET = 0x01;

    /**
     * Browser controller.
     *
     * - WebKitWebView pointer (WebKitGTK)
     * - WKWebView pointer (Cocoa/WebKit)
     * - ICoreWebView2Controller pointer (Win32/WebView2)
     */
    public const int WEBVIEW_NATIVE_HANDLE_KIND_BROWSER_CONTROLLER = 0x02;

    private function __construct() {}
}
