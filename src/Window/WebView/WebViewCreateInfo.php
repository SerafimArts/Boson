<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\WebView;

final readonly class WebViewCreateInfo
{
    public function __construct(
        public ?string $userAgent = null,
    ) {}
}
