<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Styles;

use JetBrains\PhpStorm\Language;
use Serafim\Boson\Exception\WebViewStyleException;

/**
 * @template-implements \IteratorAggregate<array-key, non-empty-string>
 */
final readonly class WebViewFrozenStylesMap implements WebViewStylesMapInterface, \IteratorAggregate
{
    public function __construct(
        private WebViewStylesMapInterface $styles,
    ) {}

    public function add(#[Language('CSS')] string $style, string|int|null $id = null): never
    {
        throw new WebViewStyleException(\sprintf(
            'Unable to add initialization style "%s" after launching an application',
            $style,
        ));
    }

    public function remove(int|string $id): never
    {
        throw new WebViewStyleException(\sprintf(
            'Unable to remove initialization style (id = "%s") after app launch',
            $id,
        ));
    }

    public function getIterator(): \Traversable
    {
        return $this->styles;
    }

    public function count(): int
    {
        return $this->styles->count();
    }

    public function __toString(): string
    {
        return (string) $this->styles;
    }
}
