<?php

declare(strict_types=1);

namespace Serafim\Boson\Dispatcher\Subscription;

/**
 * @template TEvent of object
 */
interface SubscriptionInterface
{
    /**
     * @var class-string<TEvent>
     * @readonly
     */
    public string $name { get; }
}
