<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

/**
 * @property string $uri
 */
interface WebViewInterface
{
    public function isInitialized(): bool;
}
