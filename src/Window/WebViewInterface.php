<?php

declare(strict_types=1);

namespace Serafim\WinUI\Window;

interface WebViewInterface
{
    public function isInitialized(): bool;

    public function navigate(string $uri): void;
}
