<?php

declare(strict_types=1);

namespace Local\Dispatcher;

use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

interface EventDispatcherInterface extends PsrEventDispatcherInterface
{
    /**
     * Dispatches an event to all registered listeners.
     *
     * @template T of object
     *
     * @param T $event The event to pass to the event handlers/listeners.
     *
     * @return T The passed $event MUST be returned.
     */
    public function dispatch(object $event): object;
}
