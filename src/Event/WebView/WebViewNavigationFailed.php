<?php

declare(strict_types=1);

namespace Serafim\Boson\Event\WebView;

use Serafim\Boson\Exception\WebViewNavigationException;
use Serafim\Boson\Window\WebViewInterface;

final class WebViewNavigationFailed extends WebViewNavigated
{
    public function __construct(
        WebViewInterface $subject,
        public readonly WebViewNavigationException $error,
    ) {
        parent::__construct($subject);
    }

    public function __toString(): string
    {
        return \vsprintf('%s { error: %s }', [
            self::class,
            $this->error->getMessage(),
        ]);
    }
}
