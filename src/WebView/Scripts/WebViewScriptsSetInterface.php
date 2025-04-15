<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Scripts;

use JetBrains\PhpStorm\Language;

/**
 * @template-extends \Traversable<mixed, WebViewScript>
 */
interface WebViewScriptsSetInterface extends \Traversable, \Countable
{
    /**
     * Adds JavaScript code to execution.
     *
     * The specified JavaScript code will be executed ONCE
     * at the time the {@see exec()} method is called.
     *
     * @param string $code A JavaScript code for execution
     */
    public function eval(#[Language('JavaScript')] string $code): void;

    /**
     * Adds JavaScript code to execution.
     *
     * The specified JavaScript code will be executed EVERY TIME after
     * the page loads.
     *
     * @param string $code A JavaScript code for execution
     */
    public function preload(#[Language('JavaScript')] string $code): WebViewScript;

    /**
     * Adds JavaScript code to execution.
     *
     * The specified JavaScript code will be executed EVERY TIME after
     * the entire DOM is loaded.
     *
     * @param string $code A JavaScript code for execution
     */
    public function add(#[Language('JavaScript')] string $code): WebViewScript;

    /**
     * The number of registered scripts (cannot be less than 0)
     *
     * @return int<0, max>
     */
    public function count(): int;
}
