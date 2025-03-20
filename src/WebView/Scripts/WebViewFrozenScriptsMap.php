<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Scripts;

use JetBrains\PhpStorm\Language;
use Serafim\Boson\Exception\WebViewScriptException;

/**
 * @template-implements \IteratorAggregate<array-key, non-empty-string>
 */
final readonly class WebViewFrozenScriptsMap implements WebViewScriptsMapInterface, \IteratorAggregate
{
    public function __construct(
        private WebViewScriptsMapInterface $scripts,
    ) {}

    public function add(#[Language('JavaScript')] string $code, string|int|null $id = null): never
    {
        throw new WebViewScriptException(\sprintf(
            'Unable to add initialization code "%s" after launching an application',
            $code,
        ));
    }

    public function remove(int|string $id): never
    {
        throw new WebViewScriptException(\sprintf(
            'Unable to remove initialization code (id = "%s") after app launch',
            $id,
        ));
    }

    public function getIterator(): \Traversable
    {
        return $this->scripts;
    }

    public function count(): int
    {
        return $this->scripts->count();
    }

    public function __toString(): string
    {
        return (string) $this->scripts;
    }
}
