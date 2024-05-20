<?php

declare(strict_types=1);

namespace Serafim\Boson\Event;

/**
 * Any event object is the result of an action taken.
 *
 * @template TSubject of object
 */
abstract class Event implements \Stringable
{
    /**
     * This value is the number of nanoseconds elapsed from the beginning of
     * the time origin until the event was created.
     */
    public readonly int $time;

    /**
     * @param TSubject $subject The read-only subject of the {@see Event} class.
     *        A reference to the object that sent the event.
     */
    public function __construct(
        public object $subject,
        ?int $time = null,
    ) {
        $this->time = $time ?? \hrtime(true);
    }

    public function __toString(): string
    {
        return static::class;
    }
}
