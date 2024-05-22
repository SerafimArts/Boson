<?php

declare(strict_types=1);

namespace Local\Dispatcher\Subscription;

/**
 * @template T of object
 * @template-extends SubscriptionInterface<T>
 */
interface CancellableSubscriptionInterface extends SubscriptionInterface
{
    /**
     * Returns {@see true} in case of the event is
     * cancelled, {@see false} otherwise.
     */
    public function isCancelled(): bool;

    /**
     * Cancel the event listener.
     */
    public function cancel(): void;
}
