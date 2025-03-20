<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Styles;

use JetBrains\PhpStorm\Language;

/**
 * @template-extends \Traversable<array-key, non-empty-string>
 */
interface WebViewStylesMapInterface extends \Traversable, \Countable, \Stringable
{
    /**
     * Adds new CSS initialization code
     *
     * @param non-empty-string $style An initialization CSS code
     * @param array-key|null $id An optional style identifier
     *
     * @return array-key Returns the style identifier
     */
    public function add(#[Language('CSS')] string $style, string|int|null $id = null): string|int;

    /**
     * Removes an initialization CSS code by its ID
     *
     * @param array-key $id An identifier of the style
     */
    public function remove(string|int $id): void;

    /**
     * The number of registered styles (cannot be less than 0)
     *
     * @return int<0, max>
     */
    public function count(): int;
}
