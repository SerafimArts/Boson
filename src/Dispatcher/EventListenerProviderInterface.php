<?php

declare(strict_types=1);

namespace Serafim\Boson\Dispatcher;

interface EventListenerProviderInterface
{
    /**
     * Contains local event listeners.
     *
     * @readonly
     */
    public EventListenerInterface $events { get; }
}
