<?php

declare(strict_types=1);

namespace Serafim\Boson\Dispatcher;

interface EventListenerProviderInterface
{
    /**
     * Contains local event listeners.
     */
    public EventListenerInterface $events { get; }
}
