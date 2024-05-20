<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

use JetBrains\PhpStorm\Language;
use Serafim\Boson\WindowInterface;

/**
 * @property-read WindowInterface $window The window object that owns the webview.
 * @property string $uri Contains current URI
 */
interface WebViewInterface
{
    /**
     * Load HTML content to the webview.
     */
    public function load(string $content): void;

    /**
     * Directly executes JavaScript code in the webview.
     */
    public function exec(#[Language('JavaScript')] string $script): void;

    public function isInitialized(): bool;
}
