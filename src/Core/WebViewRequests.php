<?php

declare(strict_types=1);

namespace Serafim\Boson\Core;

use JetBrains\PhpStorm\Language;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

final class WebViewRequests
{
    /**
     * @var non-empty-string
     */
    private const string METHOD_NAME = 'WebViewRequestSend';

    /**
     * @var array<non-empty-string, Deferred<mixed>>
     */
    private array $requests = [];

    public function __construct(
        /**
         * Parent WebView context
         */
        private readonly WebView $webview,
    ) {
        $this->webview->bind(self::METHOD_NAME, $this->onResponseReceived(...));
    }

    /**
     * @return non-empty-string
     */
    private function createRequestId(): string
    {
        return \bin2hex(\random_bytes(16));
    }

    public function send(#[Language('JavaScript')] string $code): PromiseInterface
    {
        $id = $this->createRequestId();

        $deferred = new Deferred(function () use ($id): void {
            $this->cancel($id);
        });

        $this->requests[$id] = $deferred;

        $this->webview->eval($this->pack($id, $code));

        return $deferred->promise();
    }

    /**
     * @param non-empty-string $id
     */
    private function pack(string $id, string $code): string
    {
        return \vsprintf('%s("%s", (function() { return %s; })())', [
            self::METHOD_NAME,
            \addcslashes($id, '"'),
            $code,
        ]);
    }

    /**
     * @param non-empty-string $id
     */
    private function cancel(string $id): void
    {
        unset($this->requests[$id]);
    }

    /**
     * @param non-empty-string $id
     */
    private function onResponseReceived(string $id, mixed $value): void
    {
        if (!isset($this->requests[$id])) {
            return;
        }

        $request = $this->requests[$id];

        try {
            $this->cancel($id);
        } finally {
            $request->resolve($value);
        }
    }
}
