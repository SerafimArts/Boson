<?php

declare(strict_types=1);

namespace Local\Dispatcher\Tests\Stub;

use Local\Dispatcher\EventDispatcherInterface;
use Local\Dispatcher\EventListener;
use Local\Dispatcher\EventListenerInterface;
use Local\Dispatcher\Subscription\CancellableSubscriptionInterface;
use Local\Dispatcher\Subscription\SubscriptionInterface;

final readonly class EventListenerContainerStub implements
    EventListenerInterface,
    EventDispatcherInterface
{
    public function __construct(
        private EventListener $listener,
    ) {}

    public function dispatch(object $event): object
    {
        return $this->listener->dispatch($event);
    }

    public function addEventListener(string $event, callable $listener): CancellableSubscriptionInterface
    {
        return $this->listener->addEventListener($event, $listener);
    }

    public function removeEventListener(SubscriptionInterface $token): void
    {
        $this->listener->removeEventListener($token);
    }

    public function getListenersForEvent(object $event): iterable
    {
        return $this->listener->getListenersForEvent($event);
    }
}
