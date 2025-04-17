<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Event;

use Serafim\Boson\Shared\Marker\AsWebViewEvent;
use Serafim\Boson\WebView\WebView;

#[AsWebViewEvent]
final class WebViewMessageReceiving extends WebViewIntention
{
    public function __construct(
        WebView $subject,
        public string $message,
        ?int $time = null,
    ) {
        parent::__construct($subject, $time);
    }

    public function ack(): void
    {
        $this->stopPropagation();
        $this->cancel();
    }
}
