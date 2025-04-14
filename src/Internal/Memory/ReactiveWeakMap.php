<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal\Memory;

/**
 * Allows to store a set of objects with referenced values and
 * track their destruction (react to GC cleanup).
 *
 * ```
 * // ReactiveWeakMap<ExampleId, CData>
 * $map = new ReactiveWeakMap();
 *
 * $map->watch($id, $data, function(CData $ref) {
 *     echo vsprintf('ID has been destroyed, something can be done with its reference %s(%d)', [
 *         $ref::class,
 *         get_object_id($ref),
 *     ]);
 * ));
 * ```
 *
 * @template TKey of object = object
 * @template TValue of object = object
 * @template-implements \IteratorAggregate<TKey, TValue>
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson
 */
final readonly class ReactiveWeakMap implements \IteratorAggregate, \Countable
{
    /**
     * @var \WeakMap<TKey, OnDestructor<TValue>>
     */
    private \WeakMap $memory;

    public function __construct()
    {
        $this->memory = new \WeakMap();
    }

    /**
     * @param TKey $key
     * @param TValue $value
     * @param \Closure(TValue):void $onRelease
     *
     * @return TKey
     */
    public function watch(object $key, object $value, \Closure $onRelease): object
    {
        $this->memory[$key] = new OnDestructor($value, $onRelease);

        return $key;
    }

    /**
     * @param TKey $key
     *
     * @return TValue|null
     */
    public function find(object $key): ?object
    {
        /**
         * @var TValue|null
         *
         * @phpstan-ignore-next-line : PHPStan does not support WeakMaps correctly
         */
        return $this->memory[$key]?->entry;
    }

    public function getIterator(): \Traversable
    {
        foreach ($this->memory as $key => $ref) {
            yield $key => $ref->entry;
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
