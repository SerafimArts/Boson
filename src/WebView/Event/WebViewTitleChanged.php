<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Event;

use Serafim\Boson\Shared\Marker\AsWebViewEvent;
use Serafim\Boson\WebView\WebView;

#[AsWebViewEvent]
final class WebViewTitleChanged extends WebViewEvent
{
    public function __construct(
        WebView $subject,
        public readonly string $title,
        ?int $time = null,
    ) {
        parent::__construct($subject, $time);
    }
}
