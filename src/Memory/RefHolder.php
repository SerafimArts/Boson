<?php

declare(strict_types=1);

namespace Serafim\WinUI\Memory;

/**
 * The class is responsible for keeping objects in PHP memory from
 * being destroyed by PHP's GC.
 */
final class RefHolder
{
    /**
     * @var \SplObjectStorage<object, mixed>|null
     */
    private static ?\SplObjectStorage $objects = null;

    /**
     * Add an object to hold in memory.
     */
    public static function capture(object $object): void
    {
        (self::$objects ??= new \SplObjectStorage())
            ->attach($object);
    }

    /**
     * Remove object holding from memory.
     */
    public static function release(object $object): void
    {
        (self::$objects ??= new \SplObjectStorage())
            ->detach($object);
    }
}
