<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

interface WebViewProviderInterface
{
    /**
     * Gets window's webview instance.
     */
    public WebViewInterface $webview { get; }
}
