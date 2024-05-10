<?php

declare(strict_types=1);

namespace Serafim\WinUI\Memory;

/**
 * @template TReference of object
 */
final readonly class MemorySet
{
    /**
     * @var \WeakMap<TReference, DestructorCallback<TReference>>
     *
     * @phpstan-ignore-next-line
     */
    private \WeakMap $references;

    public function __construct()
    {
        $this->references = new \WeakMap();
    }

    /**
     * @param TReference $reference
     * @param callable(TReference):void $onRelease
     */
    public function create(object $reference, callable $onRelease): void
    {
        // @phpstan-ignore-next-line
        $this->references[$reference] = DestructorCallback::create($reference, $onRelease);
    }
}
