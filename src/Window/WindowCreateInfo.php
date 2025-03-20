<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

use Serafim\Boson\WebView\WebViewCreateInfo;

/**
 * Information (configuration) about creating a new physical window
 */
abstract readonly class WindowCreateInfo
{
    public function __construct(
        /**
         * Information (configuration) about creating a new webview object
         * that will be attached to the window.
         */
        public WebViewCreateInfo $webview = new WebViewCreateInfo(),
    ) {}
}
