<?php

declare(strict_types=1);

namespace Serafim\Boson\Dispatcher\Subscription;

/**
 * @template TEvent of object = object
 */
interface SubscriptionInterface
{
    /**
     * @var class-string<TEvent>
     */
    public string $name { get; }
}
