<?php

declare(strict_types=1);

namespace Serafim\Boson\Tests\Unit\Dispatcher\Stub;

use Serafim\Boson\Dispatcher\EventDispatcherInterface;
use Serafim\Boson\Dispatcher\EventListener;
use Serafim\Boson\Dispatcher\EventListenerInterface;
use Serafim\Boson\Dispatcher\Subscription\CancellableSubscriptionInterface;
use Serafim\Boson\Dispatcher\Subscription\SubscriptionInterface;

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

    public function removeEventListener(SubscriptionInterface $subscription): void
    {
        $this->listener->removeEventListener($subscription);
    }

    public function removeAllEventListenersForEvent(string $event): void
    {
        $this->listener->removeAllEventListenersForEvent($event);
    }

    public function getListenersForEvent(object $event): iterable
    {
        return $this->listener->getListenersForEvent($event);
    }
}
