<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView;

/**
 * Information (configuration) about creating a new webview object.
 */
readonly class WebViewCreateInfo
{
    /**
     * List of bootstrap scripts which will always be loaded on any page
     *
     * @var array<array-key, non-empty-string>
     */
    public array $scripts;

    /**
     * List of bootstrap styles which will always be loaded on any page
     *
     * @var array<array-key, non-empty-string>
     */
    public array $styles;

    /**
     * List of global functions that will be added to the WebView
     *
     * @var array<non-empty-string, \Closure>
     */
    public array $functions;

    /**
     * @param iterable<array-key, non-empty-string> $scripts
     * @param iterable<array-key, non-empty-string> $styles
     * @param iterable<non-empty-string, \Closure> $functions
     */
    public function __construct(
        iterable $scripts = [],
        iterable $styles = [],
        iterable $functions = [],
    ) {
        $this->styles = \iterator_to_array($styles, true);
        $this->scripts = \iterator_to_array($scripts, true);
        $this->functions = \iterator_to_array($functions, true);
    }
}
