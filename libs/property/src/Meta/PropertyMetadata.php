<?php

declare(strict_types=1);

namespace Local\Property\Meta;

final readonly class PropertyMetadata
{
    /**
     * @param non-empty-string $name
     * @param non-empty-string $local
     */
    public function __construct(
        public string $name,
        public string $local,
        public bool $isReadable = true,
        public bool $isWritable = true,
        public bool $isMethodMapping = true,
    ) {}

    public function isReadOnly(): bool
    {
        return $this->isReadable && !$this->isWritable;
    }

    public function isWriteOnly(): bool
    {
        return $this->isWritable && !$this->isReadable;
    }
}
