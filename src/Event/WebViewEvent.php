<?php

declare(strict_types=1);

namespace Serafim\WinUI\Event;

use Serafim\WinUI\Window\WebViewInterface;
use Serafim\WinUI\WindowInterface;

abstract class WebViewEvent extends WindowEvent
{
    public function __construct(
        WindowInterface $target,
        public readonly WebViewInterface $webview,
    ) {
        parent::__construct($target);
    }
}
