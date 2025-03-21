<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

final readonly class URLWebViewCreateInfo extends WebViewCreateInfo
{
    /**
     * @param iterable<array-key, non-empty-string> $scripts
     * @param iterable<array-key, non-empty-string> $styles
     * @param iterable<non-empty-string, \Closure> $functions
     */
    public function __construct(
        /**
         * An external URL that should be loaded when the application starts
         *
         * @var non-empty-string
         */
        public string $url,
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
