<?php

declare(strict_types=1);

namespace Local\Property\Meta;

use Local\Property\Attribute\MapProperty;

final readonly class AttributeReader implements ReaderInterface
{
    /**
     * @param class-string $class
     * @return \Iterator<array-key, PropertyMetadata>
     * @throws \ReflectionException
     */
    public function read(string $class): \Iterator
    {
        $reflection = new \ReflectionClass($class);

        foreach ($reflection->getProperties() as $reflectionProperty) {
            // Skip non-readable properties
            if (!$this->canPropertyContainAttribute($reflectionProperty)) {
                continue;
            }

            foreach ($this->getPropertyAttributes($reflectionProperty) as $attribute) {
                /** @var non-empty-string $property */
                $property = $reflectionProperty->name;

                yield new PropertyMetadata(
                    name: $attribute->name ?? $property,
                    local: $property,
                    isReadable: $attribute->access->isReadable(),
                    isWritable: $attribute->access->isWritable(),
                    isMethodMapping: false,
                );
            }
        }

        foreach ($reflection->getMethods() as $reflectionMethod) {
            // Skip non-readable methods
            if (!$this->canMethodContainAttribute($reflectionMethod)) {
                continue;
            }

            foreach ($this->getMethodAttributes($reflectionMethod) as $attribute) {
                /** @var non-empty-string $property */
                $property = $reflectionMethod->name;

                yield new PropertyMetadata(
                    name: $attribute->name ?? $property,
                    local: $property,
                    isReadable: $attribute->access->isReadable(),
                    isWritable: $attribute->access->isWritable(),
                    isMethodMapping: true,
                );
            }
        }
    }

    /**
     * @return iterable<array-key, MapProperty>
     */
    private function getMethodAttributes(\ReflectionMethod $method): iterable
    {
        $attributes = $method->getAttributes(MapProperty::class, \ReflectionAttribute::IS_INSTANCEOF);

        foreach ($attributes as $attribute) {
            yield $attribute->newInstance();
        }
    }

    /**
     * @return iterable<array-key, MapProperty>
     */
    private function getPropertyAttributes(\ReflectionProperty $property): iterable
    {
        $attributes = $property->getAttributes(MapProperty::class, \ReflectionAttribute::IS_INSTANCEOF);

        foreach ($attributes as $attribute) {
            yield $attribute->newInstance();
        }
    }

    private function canPropertyContainAttribute(\ReflectionProperty $property): bool
    {
        return ! $property->isStatic()
            || ! $property->isPrivate();
    }

    private function canMethodContainAttribute(\ReflectionMethod $method): bool
    {
        return ! $method->isStatic()
            && ! $method->isPrivate()
            && ! $method->isAbstract()
            && ! $method->isConstructor()
            && ! $method->isDestructor()
            && ! $method->isInternal();
    }
}
