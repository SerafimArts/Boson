<?php

declare(strict_types=1);

namespace Serafim\WinUI\Memory;

/**
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
