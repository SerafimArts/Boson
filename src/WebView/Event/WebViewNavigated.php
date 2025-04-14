<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Event;

use Serafim\Boson\WebView\Uri\Uri;
use Serafim\Boson\WebView\WebView;

final class WebViewNavigated extends WebViewEvent
{
    public function __construct(
        WebView $subject,
        public readonly Uri $uri,
        ?int $time = null,
    ) {
        parent::__construct($subject, $time);
    }
}
