<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Uri;

interface UriParserInterface
{
    /**
     * Parse given uri string to an {@see Uri}.
     */
    public function parse(string $uri): Uri;
}
