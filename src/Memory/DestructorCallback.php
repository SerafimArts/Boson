<?php

declare(strict_types=1);

namespace Serafim\Boson\Memory;

/**
 * An object that allows you to add a callback to the reference destructor.
 *
 * ```
 * $map = new \WeakMap();
 *
 * // When the [$ref] is released, the [$target] is also released,
 * // causing the corresponding callback.
 *
 * $map[$ref] = DestructorCallback::create($target, function (object $target) {
 *     var_dump(vsprintf('Reference of %s (id #%d) has been destroyed', [
 *         $target::class,
 *         \spl_object_id($target),
 *     ]);
 * });
 * ```
 *
 * @template TReference of object
 */
final readonly class DestructorCallback
{
    /**
     * @param TReference $reference
     * @param \Closure(TReference):void $listener
     */
    private function __construct(
        private object $reference,
        private \Closure $listener,
    ) {}

    /**
     * @return TReference
     */
    public function getReference(): object
    {
        return $this->reference;
    }

    /**
     * @template TReferenceArg of object
     *
     * @param TReferenceArg $entry
     * @param callable(TReferenceArg):void $onRelease
     *
     * @return self<TReferenceArg>
     */
    public static function create(object $entry, callable $onRelease): self
    {
        return new self($entry, $onRelease(...));
    }

    public function __destruct()
    {
        ($this->listener)($this->reference);
    }
}
