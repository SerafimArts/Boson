<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Uri;

final class MemoizedUriParser implements UriParserInterface
{
    /**
     * Contains last parsed input uri string.
     */
    private ?string $lastUri = null;

    /**
     * Contains last parsed output uri instance.
     */
    private ?Uri $lastParsedUri = null;

    public function __construct(
        private readonly UriParserInterface $delegate,
    ) {}

    public function parse(string $uri): Uri
    {
        if ($uri === $this->lastUri && $this->lastParsedUri !== null) {
            return $this->lastParsedUri;
        }

        $this->lastUri = $uri;

        return $this->lastParsedUri = $this->delegate->parse($uri);
    }
}
