<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Scripts;

use JetBrains\PhpStorm\Language;

/**
 * @template-implements \IteratorAggregate<array-key, non-empty-string>
 */
final class WebViewScriptsMap implements WebViewScriptsMapInterface, \IteratorAggregate
{
    /**
     * @var array<array-key, non-empty-string>
     */
    private array $scripts = [];

    public function add(#[Language('JavaScript')] string $code, string|int|null $id = null): string|int
    {
        if ($id === null) {
            $this->scripts[] = $code;

            return \array_key_last($this->scripts);
        }

        $this->scripts[$id] = $code;

        return $id;
    }

    public function remove(int|string $id): void
    {
        unset($this->scripts[$id]);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->scripts);
    }

    public function count(): int
    {
        return \count($this->scripts);
    }

    public function __toString(): string
    {
        $result = '';

        foreach ($this->scripts as $script) {
            $result .= $script . ";\n";
        }

        return $result;
    }
}
