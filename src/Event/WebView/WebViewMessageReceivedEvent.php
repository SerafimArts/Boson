<?php

declare(strict_types=1);

namespace Serafim\Boson\Event\WebView;

use Serafim\Boson\Event\WebViewEvent;
use Serafim\Boson\Window\WebViewInterface;

final class WebViewMessageReceivedEvent extends WebViewEvent
{
    /**
     * @param array<array-key, mixed> $data
     */
    public function __construct(
        WebViewInterface $subject,
        public readonly array $data,
    ) {
        parent::__construct($subject);
    }

    public function __toString(): string
    {
        return \vsprintf('%s { data: %s }', [
            self::class,
            \json_encode($this->data),
        ]);
    }
}
