<?php

declare(strict_types=1);

namespace Serafim\WinUI\Memory;

final class RefHolder
{
    /**
     * @var \SplObjectStorage<object, mixed>|null
     */
    private static ?\SplObjectStorage $objects = null;

    public static function capture(object $object): void
    {
        (self::$objects ??= new \SplObjectStorage())
            ->attach($object);
    }

    public static function release(object $object): void
    {
        (self::$objects ??= new \SplObjectStorage())
            ->detach($object);
    }
}
