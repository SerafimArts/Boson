<?php

declare(strict_types=1);

namespace Serafim\Boson\Shared\Memory;

/**
 * Allows to store a set of objects and track their
 * destruction (react to GC cleanup).
 *
 * ```
 * // ReactiveWeakSet<ExampleObject>
 * $set = new ReactiveWeakSet();
 *
 * $set->watch($object, function(ExampleObject $ref) {
 *      echo vsprintf('ExampleObject(%d) has been destroyed', [
 *          get_object_id($ref),
 *      ]);
 * ));
 * ```
 *
 * @template TEntry of object
 * @template-implements \IteratorAggregate<array-key, TEntry>
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson
 */
final readonly class ReactiveWeakSet implements \IteratorAggregate, \Countable
{
    /**
     * @var \WeakMap<TEntry, OnDestructor<TEntry>>
     */
    private \WeakMap $memory;

    public function __construct()
    {
        $this->memory = new \WeakMap();
    }

    /**
     * @template TArgEntry of TEntry
     *
     * @param TArgEntry $entry
     * @param callable(TArgEntry):void $onRelease
     *
     * @return TArgEntry
     */
    public function watch(object $entry, callable $onRelease): object
    {
        $this->memory[$entry] = OnDestructor::create($entry, $onRelease);

        return $entry;
    }

    public function getIterator(): \Traversable
    {
        foreach ($this->memory as $key => $_) {
            yield $key;
        }
    }

    /**
     * @return int<0, max>
     */
    public function count(): int
    {
        return $this->memory->count();
    }
}
