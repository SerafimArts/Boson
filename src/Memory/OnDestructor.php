<?php

declare(strict_types=1);

namespace Serafim\Boson\Memory;

/**
 * @template TEntry of object
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson
 */
final readonly class OnDestructor
{
    private function __construct(
        /**
         * @var TEntry
         */
        public object $entry,
        /**
         * @var \Closure(TEntry):void
         */
        private \Closure $onRelease,
    ) {}

    /**
     * @template TArgEntry of object
     *
     * @param TArgEntry $entry
     * @param callable(TArgEntry):void $onRelease
     *
     * @return self<TArgEntry>
     */
    public static function create(object $entry, callable $onRelease): self
    {
        return new self($entry, $onRelease(...));
    }

    public function __destruct()
    {
        ($this->onRelease)($this->entry);
    }
}
