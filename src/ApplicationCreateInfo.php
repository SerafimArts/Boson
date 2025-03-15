<?php

declare(strict_types=1);

namespace Serafim\Boson;

use Serafim\Boson\Core\WebViewCreateInfo;

final readonly class ApplicationCreateInfo
{
    public function __construct(
        public WebViewCreateInfo $webview = new WebViewCreateInfo(),
    ) {}
}
