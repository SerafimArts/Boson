<?php

declare(strict_types=1);

namespace Serafim\Boson\Dispatcher;

use Psr\EventDispatcher\StoppableEventInterface;
use Serafim\Boson\Dispatcher\Subscription\CancellableSubscription;
use Serafim\Boson\Dispatcher\Subscription\CancellableSubscriptionInterface;
use Serafim\Boson\Dispatcher\Subscription\SubscriptionInterface;

class EventListener implements EventListenerInterface, EventDispatcherInterface
{
    /**
     * @var array<class-string<object>, array<array-key, callable(object):void>>
     */
    protected array $listeners = [];

    public function getListenersForEvent(object $event): iterable
    {
        if (!isset($this->listeners[$event::class])) {
            return [];
        }

        return $this->listeners[$event::class];
    }

    /**
     * @param SubscriptionInterface<object> $subscription
     */
    private function getId(SubscriptionInterface $subscription): int
    {
        return \spl_object_id($subscription);
    }

    public function addEventListener(string $event, callable $listener): CancellableSubscriptionInterface
    {
        $subscription = new CancellableSubscription(
            name: $event,
            canceller: $this->removeEventListener(...),
        );

        $this->listeners[$event][$this->getId($subscription)] = $listener(...);

        return $subscription;
    }

    public function removeEventListener(SubscriptionInterface $subscription): void
    {
        $id = $this->getId($subscription);

        unset($this->listeners[$subscription->name][$id]);
    }

    public function removeAllEventListenersForEvent(string $event): void
    {
        unset($this->listeners[$event]);
    }

    private function dispatchStoppableEvent(StoppableEventInterface $event): void
    {
        foreach ($this->getListenersForEvent($event) as $listener) {
            if ($event->isPropagationStopped()) {
                break;
            }

            $listener($event);
        }
    }

    public function dispatch(object $event): object
    {
        if ($event instanceof StoppableEventInterface) {
            $this->dispatchStoppableEvent($event);

            return $event;
        }

        foreach ($this->getListenersForEvent($event) as $listener) {
            $listener($event);
        }

        return $event;
    }
}
