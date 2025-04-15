<?php

declare(strict_types=1);

namespace Serafim\Boson\Dispatcher;

use Psr\EventDispatcher\StoppableEventInterface;
use Serafim\Boson\Dispatcher\Subscription\CancellableSubscription;
use Serafim\Boson\Dispatcher\Subscription\CancellableSubscriptionInterface;
use Serafim\Boson\Dispatcher\Subscription\SubscriptionInterface;
use Serafim\Boson\Internal\IdGenerator\GeneratorInterface;
use Serafim\Boson\Internal\IdGenerator\IntGenerator;

class EventListener implements EventListenerInterface, EventDispatcherInterface
{
    /**
     * @var array<class-string<object>, array<array-key, callable(object):void>>
     */
    protected array $listeners = [];

    /**
     * @var GeneratorInterface<array-key>
     */
    private readonly GeneratorInterface $idGenerator;

    public function __construct()
    {
        $this->idGenerator = IntGenerator::createFromEnvironment();
    }

    public function getListenersForEvent(object $event): iterable
    {
        if (!isset($this->listeners[$event::class])) {
            return [];
        }

        return $this->listeners[$event::class];
    }

    public function addEventListener(string $event, callable $listener): CancellableSubscriptionInterface
    {
        $subscription = new CancellableSubscription(
            id: $this->idGenerator->nextId(),
            name: $event,
            // @phpstan-ignore-next-line
            canceller: $this->removeEventListener(...),
        );

        // @phpstan-ignore-next-line
        $this->listeners[$event][$subscription->id] = $listener(...);

        return $subscription;
    }

    public function removeEventListener(SubscriptionInterface $subscription): void
    {
        unset($this->listeners[$subscription->name][$subscription->id]);
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
