<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal\Memory;

/**
 * @template TEntry of object
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson
 */
final readonly class OnDestructor
{
    public function __construct(
        /**
         * @var TEntry
         */
        public object $entry,
        /**
         * @var \Closure(TEntry):void
         */
        private \Closure $onRelease,
    ) {}

    public function __destruct()
    {
        ($this->onRelease)($this->entry);
    }
}
