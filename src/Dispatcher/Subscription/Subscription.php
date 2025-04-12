<?php

declare(strict_types=1);

namespace Serafim\Boson\Dispatcher\Subscription;

/**
 * @template T of object
 * @template-implements SubscriptionInterface<T>
 */
class Subscription implements SubscriptionInterface
{
    /**
     * @param class-string<T> $name
     */
    public function __construct(
        public readonly string $name,
    ) {}
}
