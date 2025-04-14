<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Event;

use Serafim\Boson\WebView\Url\Url;
use Serafim\Boson\WebView\WebView;

final class WebViewNavigating extends WebViewIntention
{
    public function __construct(
        WebView $subject,
        public readonly Url $uri,
        public readonly bool $isNewWindow,
        public readonly bool $isRedirection,
        public readonly bool $isUserInitiated,
        ?int $time = null,
    ) {
        parent::__construct($subject, $time);
    }
}
