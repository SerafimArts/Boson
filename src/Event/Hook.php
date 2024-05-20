<?php

declare(strict_types=1);

namespace Serafim\Boson\Event;

use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Any hook object is an intent to perform an event.
 *
 * Any intention can be interrupted using the {@see self::isPropagationStopped()} method
 * or changing any available data.
 */
abstract class Hook extends Event implements StoppableEventInterface
{
    private bool $propagationStopped = false;

    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    /**
     * Stops the propagation of the hook to further event listeners.
     *
     * If multiple event listeners are connected to the same event, no
     * further event listener will be triggered once any trigger
     * calls {@see self::stopPropagation()}.
     */
    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }
}
