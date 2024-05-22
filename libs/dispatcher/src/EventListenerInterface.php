<?php

declare(strict_types=1);

namespace Local\Dispatcher;

use Local\Dispatcher\Subscription\CancellableSubscriptionInterface;
use Local\Dispatcher\Subscription\SubscriptionInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

interface EventListenerInterface extends ListenerProviderInterface
{
    /**
     * Adds an event listener that listens on the specified events.
     *
     * @template T of object
     *
     * @param class-string<T> $event The event (class) name.
     * @param callable(T):void $listener The listener callback.
     *
     * @return CancellableSubscriptionInterface<T>
     */
    public function addEventListener(string $event, callable $listener): CancellableSubscriptionInterface;

    /**
     * Removes an event listener from the specified events.
     *
     * @param CancellableSubscriptionInterface<object> $token An event subscription token.
     */
    public function removeEventListener(SubscriptionInterface $token): void;

    /**
     * @template T of object
     *
     * @param T $event An event for which to return the relevant listeners.
     *
     * @return iterable<array-key, callable(T):void> An iterable (array,
     *         iterator, or generator) of callables. Each callable MUST be
     *         type-compatible with $event.
     */
    public function getListenersForEvent(object $event): iterable;
}
