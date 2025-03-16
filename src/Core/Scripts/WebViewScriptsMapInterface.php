<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Scripts;

use JetBrains\PhpStorm\Language;

/**
 * @template-extends \Traversable<array-key, non-empty-string>
 */
interface WebViewScriptsMapInterface extends \Traversable, \Countable, \Stringable
{
    /**
     * Adds new JavaScript initialization code
     *
     * @param non-empty-string $code An initialization JavaScript code
     * @param array-key|null $id An optional script identifier
     *
     * @return array-key Returns the script identifier
     */
    public function add(#[Language('JavaScript')] string $code, string|int|null $id = null): string|int;

    /**
     * Removes an initialization JavaScript code by its ID
     *
     * @param array-key $id An identifier of the code
     */
    public function remove(string|int $id): void;

    /**
     * The number of registered scripts (cannot be less than 0)
     *
     * @return int<0, max>
     */
    public function count(): int;
}
