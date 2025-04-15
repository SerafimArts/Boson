<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Requests;

use JetBrains\PhpStorm\Language;
use Serafim\Boson\Internal\Application\ProcessUnlockPlaceholder;
use Serafim\Boson\Internal\IdGenerator\GeneratorInterface;
use Serafim\Boson\Internal\IdGenerator\IntGenerator;
use Serafim\Boson\WebView\Requests\Exception\StalledRequestException;
use Serafim\Boson\WebView\Requests\Exception\UnprocessableRequestException;
use Serafim\Boson\WebView\WebView;

final class WebViewRequests implements WebViewRequestsInterface
{
    private const float DEFAULT_REQUEST_TIMEOUT = 0.1;

    /**
     * @var non-empty-string
     */
    private const string METHOD_NAME = '__bosonSendResponse';

    private const string BOSON_RESPONSE = <<<'JS'
        %s("%s", eval(`%s`));
        JS;

    /**
     * Contains request ID generator
     *
     * @var GeneratorInterface<array-key>
     */
    private readonly GeneratorInterface $idGenerator;

    /**
     * @var array<array-key, mixed>
     */
    private array $results = [];

    private float $lastRequestSentTime = 0.0;

    /**
     * Returns the amount of time remaining to process the request
     */
    private float $timeLeft {
        get => $this->lastRequestSentTime - \microtime(true) + $this->timeout;
    }

    public function __construct(
        /**
         * Parent WebView context
         */
        private readonly WebView $webview,
        private readonly ProcessUnlockPlaceholder $placeholder,
        private readonly float $timeout = self::DEFAULT_REQUEST_TIMEOUT,
    ) {
        $this->idGenerator = IntGenerator::createFromEnvironment();

        $this->webview->bind(self::METHOD_NAME, $this->onResponseReceived(...));
    }

    public function send(#[Language('JavaScript')] string $code): mixed
    {
        if ($code === '') {
            return '';
        }

        $id = $this->idGenerator->nextId();

        $this->webview->eval($this->pack($id, $code));
        $this->lastRequestSentTime = \microtime(true);

        while ($this->placeholder->next()) {
            if (!\array_key_exists($id, $this->results)) {
                if (($timeLeft = $this->timeLeft) < 0) {
                    throw StalledRequestException::becauseRequestIsStalled(
                        $code,
                        ($timeLeft - $this->timeout) * -1,
                    );
                }

                continue;
            }

            try {
                return $this->results[$id];
            } finally {
                unset($this->results[$id]);
            }
        }

        throw UnprocessableRequestException::becauseRequestIsUnprocessable($code);
    }

    /**
     * @param array-key $id
     */
    private function pack(string|int $id, string $code): string
    {
        return \vsprintf(self::BOSON_RESPONSE, [
            self::METHOD_NAME,
            \addcslashes((string) $id, '"'),
            \addcslashes($code, '`'),
        ]);
    }

    /**
     * @param array-key $id
     */
    private function onResponseReceived(string|int $id, mixed $value): void
    {
        $this->results[$id] = $value;
    }
}
