<?php

declare(strict_types=1);

namespace Local\WebView2\Shared;

use Local\Com\Exception\ResultException;
use Local\Com\IUnknown as BaseIUnknown;
use Local\WebView2\WebView2;

/**
 * @template-extends BaseIUnknown<WebView2>
 */
abstract class IUnknown extends BaseIUnknown
{
    use ContainEventHandlers;

    /**
     * @param non-empty-string $method
     * @param list<mixed> $args
     */
    protected function call(string $method, array $args = []): void
    {
        if (($result = $this->callGetResult($method, $args)) !== 0) {
            $metadata = self::getStructMetadata();

            throw ResultException::fromStructMetadata($metadata, $method, $result);
        }
    }

    /**
     * @param non-empty-string $method
     * @param list<mixed> $args
     */
    protected function callGetResult(string $method, array $args = []): int
    {
        /** @var callable $proc */
        $proc = $this->vt->$method;

        return $proc($this->cdata, ...$args);
    }

    public function __destruct()
    {
        $this->tearDownContainEventHandlers();

        parent::__destruct();
    }
}
