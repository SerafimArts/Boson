<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Url;

final class MemoizedUrlParser implements UrlParserInterface
{
    /**
     * Contains last parsed input uri string.
     */
    private ?string $lastUri = null;

    /**
     * Contains last parsed output uri instance.
     */
    private ?Url $lastParsedUri = null;

    public function __construct(
        private readonly UrlParserInterface $delegate,
    ) {}

    public function parse(string $url): Url
    {
        if ($url === $this->lastUri && $this->lastParsedUri !== null) {
            return $this->lastParsedUri;
        }

        $this->lastUri = $url;

        return $this->lastParsedUri = $this->delegate->parse($url);
    }
}
