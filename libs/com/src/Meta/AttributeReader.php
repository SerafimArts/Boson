<?php

declare(strict_types=1);

namespace Local\Com\Meta;

use Local\Com\Attribute\MapCallback;
use Local\Com\Attribute\MapStruct;

final readonly class AttributeReader implements ReaderInterface
{
    public function read(string $class): StructMetadata
    {
        $reflection = new \ReflectionClass($class);

        $struct = $this->findStructAttributeFromClass($reflection);

        return new StructMetadata(
            class: $reflection->getName(),
            // @phpstan-ignore-next-line
            name: $struct->name ?? $reflection->getShortName(),
            callbacks: $this->getCallbacks($reflection),
            isOwned: $struct->owned ?? true,
        );
    }

    /**
     * @param \ReflectionClass<object> $class
     * @return array<non-empty-string, CallbackMetadata>
     */
    private function getCallbacks(\ReflectionClass $class): array
    {
        $result = [];

        foreach ($class->getMethods() as $method) {
            // Skip non-readable methods
            if (!$this->canMethodContainCallbackAttribute($method)) {
                continue;
            }

            $attribute = $this->findCallbackAttributeFromMethod($method);

            if ($attribute === null) {
                continue;
            }

            /** @var non-empty-string $name */
            $name = $method->name;

            $result[$name] = new CallbackMetadata(
                name: $attribute->name ?? $name,
                method: $name,
            );
        }

        /** @var array<non-empty-string, CallbackMetadata> */
        return $result;
    }

    private function canMethodContainCallbackAttribute(\ReflectionMethod $method): bool
    {
        return ! $method->isStatic()
            && ! $method->isPrivate()
            && ! $method->isAbstract()
            && ! $method->isConstructor()
            && ! $method->isDestructor()
            && ! $method->isInternal();
    }

    /**
     * @return MapCallback|null
     */
    private function findCallbackAttributeFromMethod(\ReflectionMethod $method): ?MapCallback
    {
        $attributes = $method->getAttributes(MapCallback::class, \ReflectionAttribute::IS_INSTANCEOF);

        foreach ($attributes as $attribute) {
            return $attribute->newInstance();
        }

        return null;
    }

    /**
     * @param \ReflectionClass<object> $class
     */
    private function findStructAttributeFromClass(\ReflectionClass $class): ?MapStruct
    {
        $attributes = $class->getAttributes(MapStruct::class, \ReflectionAttribute::IS_INSTANCEOF);

        foreach ($attributes as $attribute) {
            return $attribute->newInstance();
        }

        return null;
    }
}
