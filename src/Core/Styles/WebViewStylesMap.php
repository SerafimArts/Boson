<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Styles;

use JetBrains\PhpStorm\Language;

/**
 * @template-implements \IteratorAggregate<array-key, non-empty-string>
 */
final class WebViewStylesMap implements WebViewStylesMapInterface, \IteratorAggregate
{
    /**
     * @var array<array-key, non-empty-string>
     */
    private array $styles = [];

    public function add(#[Language('CSS')] string $style, string|int|null $id = null): string|int
    {
        if ($id === null) {
            $this->styles[] = $style;

            return \array_key_last($this->styles);
        }

        $this->styles[$id] = $style;

        return $id;
    }

    public function remove(int|string $id): void
    {
        unset($this->styles[$id]);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->styles);
    }

    public function count(): int
    {
        return \count($this->styles);
    }

    public function __toString(): string
    {
        $identifier = '__loadGlobalStyles' . \hash('xxh128', \serialize($this->styles));

        $styles = '';

        foreach ($this->styles as $style) {
            $styles .= $style . "\n";
        }

        return \sprintf(<<<JS
            const {$identifier} = function () {
                if (document.head) {
                    let style = document.createElement('style');
                    style.setAttribute('type', 'text/css');
                    style.appendChild(document.createTextNode(`%s`));

                    document.head.append(style);
                }
            };

            window.test = function () {}

            {$identifier}();
            document.addEventListener("DOMContentLoaded", {$identifier});
            JS, \addcslashes($styles, '`'));
    }
}
