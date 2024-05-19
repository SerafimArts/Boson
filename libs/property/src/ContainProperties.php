<?php

declare(strict_types=1);

namespace Local\Property;

use Local\Property\Exception\PropertyNotReadableException;
use Local\Property\Exception\PropertyNotWritableException;
use Local\Property\Meta\PropertyMetadata;

trait ContainProperties
{
    use ContainPropertiesMetadata;

    /**
     * @var array<class-string, array<non-empty-string, PropertyMetadata>>
     */
    private static array $getters = [];

    /**
     * @var array<class-string, array<non-empty-string, PropertyMetadata>>
     */
    private static array $setters = [];

    /**
     * @return array<non-empty-string, PropertyMetadata>
     */
    private static function getGetters(): array
    {
        if (!isset(self::$getters[static::class])) {
            foreach (self::getPropertiesMetadata() as $property) {
                if ($property->isReadable) {
                    self::$getters[static::class][$property->name] = $property;
                }
            }
        }

        return self::$getters[static::class];
    }

    /**
     * @return array<non-empty-string, PropertyMetadata>
     */
    private static function getSetters(): array
    {
        if (!isset(self::$setters[static::class])) {
            foreach (self::getPropertiesMetadata() as $property) {
                if ($property->isWritable) {
                    self::$setters[static::class][$property->name] = $property;
                }
            }
        }

        return self::$setters[static::class];
    }

    /**
     * @param non-empty-string $name
     */
    public function __get(string $name): mixed
    {
        $properties = self::getGetters();

        if (!isset($properties[$name])) {
            throw PropertyNotReadableException::fromPropertyName(static::class, $name);
        }

        return $this->getPropertyValue($properties[$name]);
    }

    private function getPropertyValue(PropertyMetadata $meta): mixed
    {
        $local = $meta->local;

        if ($meta->isMethodMapping) {
            return $this->{$local}();
        }

        $property = $this->$local;

        return $property->get();
    }

    /**
     * @param non-empty-string $name
     */
    public function __set(string $name, mixed $value): void
    {
        $properties = self::getSetters();

        if (($property = $properties[$name] ?? null) === null) {
            throw PropertyNotWritableException::fromPropertyName(static::class, $name);
        }

        $this->setPropertyValue($property, $value);
    }

    private function setPropertyValue(PropertyMetadata $meta, mixed $value): void
    {
        $local = $meta->local;

        if ($meta->isMethodMapping) {
            $this->{$local}($value);
            return;
        }

        $this->{$local}->set($value);
    }

    /**
     * @param non-empty-string $name
     */
    public function __isset(string $name): bool
    {
        return isset(self::getGetters()[$name])
            || isset(self::getSetters()[$name]);
    }
}
