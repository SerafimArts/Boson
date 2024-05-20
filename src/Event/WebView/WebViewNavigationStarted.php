<?php

declare(strict_types=1);

namespace Serafim\Boson\Event\WebView;

use Serafim\Boson\Event\WebViewEvent;
use Serafim\Boson\Window\WebViewInterface;

final class WebViewNavigationStarted extends WebViewEvent
{
    public function __construct(
        WebViewInterface $subject,
        public readonly string $uri,
    ) {
        parent::__construct($subject);
    }

    public function __toString(): string
    {
        return \vsprintf('%s { uri: %s }', [
            self::class,
            $this->uri,
        ]);
    }
}
