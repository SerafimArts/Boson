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
        /** @var callable $proc */
        $proc = $this->vt->$method;

        if (($result = $proc($this->cdata, ...$args)) !== 0) {
            $metadata = self::getStructMetadata();

            throw ResultException::fromStructMetadata($metadata, $method, $result);
        }
    }

    public function __destruct()
    {
        $this->tearDownContainEventHandlers();

        parent::__destruct();
    }
}
