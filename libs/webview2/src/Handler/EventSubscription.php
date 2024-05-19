<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use FFI\CData;
use Local\Com\Struct;
use Local\WebView2\WebView2;

final class EventSubscription
{
    private bool $isCancelled = false;

    /**
     * @param Struct<WebView2> $context
     * @param non-empty-string $name
     */
    public function __construct(
        private readonly Struct $context,
        private readonly CData $cdata,
        public readonly string $name,
    ) {}

    public function isCancelled(): bool
    {
        return $this->isCancelled;
    }

    public function cancel(): void
    {
        if ($this->isCancelled) {
            return;
        }

        ($this->context->vt->{'remove_' . $this->name})(
            $this->context->cdata,
            $this->cdata,
        );

        $this->isCancelled = true;
    }

    public function getId(): int
    {
        return $this->cdata->value;
    }
}
