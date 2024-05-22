<?php

declare(strict_types=1);

namespace Local\Dispatcher;

final class DelegateEventListener extends EventListener
{
    public function __construct(
        private readonly EventDispatcherInterface $delegate,
    ) {
        parent::__construct();
    }

    public function dispatch(object $event): object
    {
        return $this->delegate->dispatch(
            event: parent::dispatch($event),
        );
    }
}
