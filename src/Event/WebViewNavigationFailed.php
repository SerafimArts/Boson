<?php

declare(strict_types=1);

namespace Serafim\Boson\Event;

use Serafim\Boson\Exception\WebViewNavigationException;
use Serafim\Boson\Window\WebViewInterface;
use Serafim\Boson\WindowInterface;

final class WebViewNavigationFailed extends WebViewNavigated
{
    public function __construct(
        WindowInterface $target,
        WebViewInterface $webview,
        public readonly WebViewNavigationException $error,
    ) {
        parent::__construct($target, $webview);
    }
}
