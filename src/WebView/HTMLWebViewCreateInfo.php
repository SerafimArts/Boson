<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

use JetBrains\PhpStorm\Language;

final readonly class HTMLWebViewCreateInfo extends WebViewCreateInfo
{
    /**
     * @param iterable<array-key, non-empty-string> $scripts
     * @param iterable<array-key, non-empty-string> $styles
     * @param iterable<non-empty-string, \Closure> $functions
     */
    public function __construct(
        /**
         * Local HTML content that should be loaded when the application starts
         *
         * @var non-empty-string
         */
        #[Language('HTML')]
        public string $html,
        iterable $scripts = [],
        iterable $styles = [],
        iterable $functions = []
    ) {
        parent::__construct(
            scripts: $scripts,
            styles: $styles,
            functions: $functions,
        );
    }
}
