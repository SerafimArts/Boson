<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Requests;

use JetBrains\PhpStorm\Language;
use Serafim\Boson\WebView\Requests\Exception\UnprocessableRequestException;

interface WebViewRequestsInterface
{
    /**
     * Requests arbitrary data from webview using JavaScript code.
     *
     * ```
     * $requests->send('document.location');
     *      ->then(function(array $location): void {
     *          var_dump($location);
     *      });
     * ```
     *
     * @throws UnprocessableRequestException occurs when a response cannot be received
     */
    public function send(#[Language('JavaScript')] string $code): mixed;
}
