<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Event;

use Serafim\Boson\WebView\WebView;

final class WebViewTitleChanging extends WebViewIntention
{
    public function __construct(
        WebView $subject,
        public readonly string $title,
        ?int $time = null,
    ) {
        parent::__construct($subject, $time);
    }
}
