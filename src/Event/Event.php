<?php

declare(strict_types=1);

namespace Serafim\WinUI\Event;

/**
 * @template T of object
 */
abstract class Event
{
    /**
     * This value is the number of milliseconds elapsed from the beginning of
     * the time origin until the event was created.
     */
    public readonly int $time;

    /**
     * @param T $target The read-only target property of the {@see Event} class
     *        is a reference to the object onto which the event was dispatched.
     */
    public function __construct(
        public readonly object $target,
    ) {
        $this->time = \hrtime(true);
    }
}
