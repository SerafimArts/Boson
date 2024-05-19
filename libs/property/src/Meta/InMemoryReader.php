<?php

declare(strict_types=1);

namespace Local\Property\Meta;

final class InMemoryReader implements ReaderInterface
{
    /**
     * @var array<class-string, list<PropertyMetadata>>
     */
    private array $properties = [];

    public function __construct(
        private readonly ReaderInterface $delegate,
    ) {}

    /**
     * @param iterable<array-key, PropertyMetadata> $properties
     * @return list<PropertyMetadata>
     */
    private static function iterableToArray(iterable $properties): array
    {
        if (\is_array($properties)) {
            return $properties;
        }

        return \iterator_to_array($properties, false);
    }

    /**
     * @param class-string $class
     * @return list<PropertyMetadata>
     */
    public function read(string $class): array
    {
        return $this->properties[$class] ??= self::iterableToArray(
            properties: $this->delegate->read($class),
        );
    }
}
