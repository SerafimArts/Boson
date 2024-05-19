<?php

declare(strict_types=1);

namespace Local\Com\Meta;

/**
 * @template T of object
 */
final readonly class StructMetadata
{
    /**
     * @param class-string<T> $class
     * @param non-empty-string $name
     * @param array<non-empty-string, CallbackMetadata> $callbacks
     */
    public function __construct(
        public string $class,
        public string $name,
        public array $callbacks,
        public bool $isOwned = false,
    ) {}
}
