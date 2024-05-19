<?php

declare(strict_types=1);

namespace Local\Com\Meta;

final readonly class CallbackMetadata
{
    /**
     * @param non-empty-string $name
     * @param non-empty-string $method
     */
    public function __construct(
        public string $name,
        public string $method,
    ) {}
}
