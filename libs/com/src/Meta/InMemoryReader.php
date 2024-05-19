<?php

declare(strict_types=1);

namespace Local\Com\Meta;

final class InMemoryReader implements ReaderInterface
{
    /**
     * @var array<class-string, StructMetadata>
     */
    private array $metadata = [];

    public function __construct(
        private readonly ReaderInterface $delegate,
    ) {}

    public function read(string $class): StructMetadata
    {
        return $this->metadata[$class] ??= $this->delegate->read($class);
    }
}
