<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Requests;

use JetBrains\PhpStorm\Language;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;
use Serafim\Boson\WebView\Requests\IdGenerator\GeneratorInterface;
use Serafim\Boson\WebView\Requests\IdGenerator\Int32Generator;
use Serafim\Boson\WebView\Requests\IdGenerator\Int64Generator;
use Serafim\Boson\WebView\WebView;

use function React\Promise\resolve;

/**
 * @template-implements \IteratorAggregate<array-key, Deferred<mixed>>
 */
final class WebViewRequests implements WebViewRequestsInterface, \IteratorAggregate
{
    /**
     * @var non-empty-string
     */
    private const string METHOD_NAME = '__webViewRequestSend';

    /**
     * Contains request ID generator
     *
     * @var GeneratorInterface<array-key>
     */
    private GeneratorInterface $ids;

    /**
     * @var array<array-key, Deferred<mixed>>
     */
    private array $requests = [];

    public function __construct(
        /**
         * Parent WebView context
         */
        private readonly WebView $webview,
    ) {
        $this->ids = $this->createIdGenerator();

        $this->webview->bind(self::METHOD_NAME, $this->onResponseReceived(...));
    }

    /**
     * @return GeneratorInterface<array-key>
     */
    private function createIdGenerator(): GeneratorInterface
    {
        if (\PHP_INT_SIZE >= 8) {
            return new Int64Generator();
        }

        return new Int32Generator();
    }

    public function send(#[Language('JavaScript')] string $code): PromiseInterface
    {
        if ($code === '') {
            return resolve('');
        }

        $id = $this->ids->nextId();

        $deferred = new Deferred(function () use ($id): void {
            $this->cancel($id);
        });

        $this->requests[$id] = $deferred;

        $this->webview->eval($this->pack($id, $code));

        return $deferred->promise();
    }

    /**
     * @param array-key $id
     */
    private function pack(string|int $id, string $code): string
    {
        return \vsprintf('%s("%s", (function() { return %s; })())', [
            self::METHOD_NAME,
            \addcslashes((string) $id, '"'),
            $code,
        ]);
    }

    /**
     * @param array-key $id
     */
    private function cancel(string|int $id): void
    {
        unset($this->requests[$id]);
    }

    /**
     * @param array-key $id
     */
    private function onResponseReceived(string|int $id, mixed $value): void
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

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->requests);
    }

    public function count(): int
    {
        return \count($this->requests);
    }
}
