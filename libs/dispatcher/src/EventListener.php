<?php

declare(strict_types=1);

namespace Local\Dispatcher;

use Local\Dispatcher\Subscription\CancellableSubscription;
use Local\Dispatcher\Subscription\CancellableSubscriptionInterface;
use Local\Dispatcher\Subscription\SubscriptionInterface;
use Local\Id\IdFactory;
use Local\Id\IdFactoryInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class EventListener implements EventListenerInterface, EventDispatcherInterface
{
    /**
     * @var array<class-string<object>, array<array-key, callable(object):void>>
     */
    private array $listeners = [];

    public function __construct(
        private readonly IdFactoryInterface $ids = new IdFactory(),
    ) {}

    public function getListenersForEvent(object $event): iterable
    {
        if (!isset($this->listeners[$event::class])) {
            return [];
        }

        return $this->listeners[$event::class];
    }

    public function addEventListener(string $event, callable $listener): CancellableSubscriptionInterface
    {
        // @phpstan-ignore-next-line
        $this->listeners[$event][] = $listener;

        return new CancellableSubscription(
            id: $this->ids->create(\array_key_last($this->listeners[$event])),
            name: $event,
            // @phpstan-ignore-next-line
            canceller: $this->removeEventListener(...),
        );
    }

    public function removeEventListener(SubscriptionInterface $token): void
    {
        $id = $token->getId();

        unset($this->listeners[$token->getName()][$id->toPrimitive()]);
    }

    private function dispatchStoppableEvent(StoppableEventInterface $event): object
    {
        foreach ($this->getListenersForEvent($event) as $listener) {
            if ($event->isPropagationStopped()) {
                break;
            }

            $listener($event);
        }

        return $event;
    }

    public function dispatch(object $event): object
    {
        if ($event instanceof StoppableEventInterface) {
            return $this->dispatchStoppableEvent($event);
        }

        foreach ($this->getListenersForEvent($event) as $listener) {
            $listener($event);
        }

        return $event;
    }
}
