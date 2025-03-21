<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Binding;

use FFI\CData;
use Serafim\Boson\Core\WebView\WebViewLibrary;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson\Core\Binding
 *
 * @template TFunction of \Closure = \Closure
 */
final readonly class WebViewFunction
{
    public function __construct(
        private WebViewLibrary $api,
        private CData $webview,
        /**
         * @var TFunction
         */
        public \Closure $callback,
    ) {}

    /**
     * @return list<mixed>
     * @throws \JsonException
     */
    private static function decodeArguments(string $jsonArguments): array
    {
        if ($jsonArguments === '') {
            return [];
        }

        $result = \json_decode($jsonArguments, true, flags: \JSON_THROW_ON_ERROR);

        if (\is_array($result) && \array_is_list($result)) {
            return $result;
        }

        throw new \InvalidArgumentException('Invalid method arguments: ' . $jsonArguments);
    }

    /**
     * @throws \JsonException
     */
    private static function encodeResult(mixed $result): string
    {
        if (\is_resource($result)) {
            return (string) \get_resource_id($result);
        }

        return \json_encode($result, \JSON_THROW_ON_ERROR);
    }

    /**
     * @param non-empty-string $id
     */
    public function __invoke(string $id, string $jsonArguments, mixed $args = null): void
    {
        try {
            $arguments = self::decodeArguments($jsonArguments);

            $result = ($this->callback)(...$arguments);

            $jsonResult = self::encodeResult($result);

            $this->api->webview_return($this->webview, $id, 0, $jsonResult);
        } catch (\Throwable $e) {
            try {
                $jsonResult = self::encodeResult($e);
            } catch (\Throwable) {
                $jsonResult = (string) $e;
            }

            $this->api->webview_return($this->webview, $id, 1, $jsonResult);
        }
    }
}
