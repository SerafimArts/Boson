<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Requests;

use JetBrains\PhpStorm\Language;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

/**
 * @template-extends \Traversable<array-key, Deferred<mixed>>
 */
interface WebViewRequestsInterface extends \Traversable, \Countable
{
    /**
     * @return PromiseInterface<mixed>
     */
    public function send(#[Language('JavaScript')] string $code): PromiseInterface;

    /**
     * The number of requests cannot be less than 0
     *
     * @return int<0, max>
     */
    public function count(): int;
}
