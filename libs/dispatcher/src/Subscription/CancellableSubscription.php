<?php

declare(strict_types=1);

namespace Local\Dispatcher\Subscription;

use Local\Id\IdInterface;

/**
 * @template T of object
 * @template-extends Subscription<T>
 * @template-implements CancellableSubscriptionInterface<T>
 */
final class CancellableSubscription extends Subscription implements CancellableSubscriptionInterface
{
    private bool $cancelled = false;

    /**
     * @var \Closure(SubscriptionInterface):void
     */
    private readonly \Closure $canceller;

    /**
     * @param IdInterface<scalar> $id
     * @param class-string<T> $name
     * @param callable(SubscriptionInterface):void $canceller
     */
    public function __construct(
        IdInterface $id,
        string $name,
        callable $canceller,
    ) {
        parent::__construct($id, $name);

        $this->canceller = $canceller(...);
    }

    public function isCancelled(): bool
    {
        return $this->cancelled;
    }

    public function cancel(): void
    {
        if ($this->cancelled === false) {
            return;
        }

        ($this->canceller)($this);
        $this->cancelled = true;
    }
}
