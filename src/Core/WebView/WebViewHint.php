<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\WebView;

/**
 * Window size hints.
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson
 */
final readonly class WebViewHint
{
    /**
     * Width and height are default size.
     *
     * @api
     */
    public const int WEBVIEW_HINT_NONE = 0x00;

    /**
     * Width and height are minimum bounds.
     *
     * @api
     */
    public const int WEBVIEW_HINT_MIN = 0x01;

    /**
     * Width and height are maximum bounds.
     *
     * @api
     */
    public const int WEBVIEW_HINT_MAX = 0x02;

    /**
     * Window size can not be changed by a user.
     *
     * @api
     */
    public const int WEBVIEW_HINT_FIXED = 0x03;

    private function __construct() {}
}
