<?php

declare(strict_types=1);

namespace Serafim\WinUI\Property;

use Serafim\WinUI\Exception\PropertyNotFoundException;
use Serafim\WinUI\Exception\PropertyNotReadableException;
use Serafim\WinUI\Exception\PropertyNotWritableException;

trait PropertyProviderTrait
{
    /**
     * @var array<non-empty-string, Property<mixed, mixed>>
     */
    private array $properties = [];

    /**
     * @param non-empty-string $name
     *
     * @return Property<mixed, mixed>
     */
    private function getProperty(string $name): Property
    {
        return $this->findProperty($name)
            ?? throw PropertyNotFoundException::fromPropertyName(static::class, $name);
    }

    /**
     * @param non-empty-string $name
     *
     * @return Property<mixed, mixed>|null
     */
    private function findProperty(string $name): ?Property
    {
        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        }

        if (!\method_exists($this, $name)) {
            return null;
        }

        // @phpstan-ignore-next-line
        $property = $this->$name();

        if (!$property instanceof Property) {
            return null;
        }

        if ($property->memoized) {
            return $this->properties[$name] = $property;
        }

        return $property;
    }

    /**
     * @param non-empty-string $name
     */
    private function hasProperty(string $name): bool
    {
        return $this->findProperty($name) !== null;
    }

    /**
     * @param non-empty-string $name
     */
    private function getPropertyValue(string $name): mixed
    {
        $property = $this->getProperty($name);

        if ($property->getter === null) {
            throw PropertyNotReadableException::fromPropertyName(static::class, $name);
        }

        return ($property->getter)();
    }

    /**
     * @param non-empty-string $name
     */
    private function setPropertyValue(string $name, mixed $value): void
    {
        $property = $this->getProperty($name);

        if ($property->setter === null) {
            throw PropertyNotWritableException::fromPropertyName(static::class, $name);
        }

        ($property->setter)($value);
    }

    /**
     * @param non-empty-string $name
     */
    public function __isset(string $name): bool
    {
        return $this->hasProperty($name);
    }

    /**
     * @param non-empty-string $name
     */
    public function __get(string $name): mixed
    {
        return $this->getPropertyValue($name);
    }

    /**
     * @param non-empty-string $name
     */
    public function __set(string $name, mixed $value): void
    {
        $this->setPropertyValue($name, $value);
    }
}
