<?php

declare(strict_types=1);

namespace Serafim\Boson\Dispatcher;

use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

final class DelegateEventListener extends EventListener
{
    public function __construct(
        private readonly PsrEventDispatcherInterface $delegate,
    ) {}

    public function dispatch(object $event): object
    {
        return $this->delegate->dispatch(
            event: parent::dispatch($event),
        );
    }
}
