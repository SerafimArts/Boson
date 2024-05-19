<?php

declare(strict_types=1);

namespace Serafim\Boson\Event;

use Serafim\Boson\Window\WebViewInterface;
use Serafim\Boson\WindowInterface;

final class WebViewNavigationStarting extends WebViewEvent
{
    public function __construct(
        WindowInterface $target,
        WebViewInterface $webview,
        public readonly string $uri,
    ) {
        parent::__construct($target, $webview);
    }
}
