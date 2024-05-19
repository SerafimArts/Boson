<?php

declare(strict_types=1);

namespace Serafim\Boson\Event;

use Serafim\Boson\Window\WebViewInterface;
use Serafim\Boson\WindowInterface;

abstract class WebViewEvent extends WindowEvent
{
    public function __construct(
        WindowInterface $target,
        public readonly WebViewInterface $webview,
    ) {
        parent::__construct($target);
    }
}
