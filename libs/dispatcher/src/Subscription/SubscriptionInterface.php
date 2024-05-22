<?php

declare(strict_types=1);

namespace Local\Dispatcher\Subscription;

use Local\Id\IdInterface;

/**
 * @template T of object
 */
interface SubscriptionInterface
{
    /**
     * Returns event identifier string.
     *
     * @return IdInterface<array-key>
     */
    public function getId(): IdInterface;

    /**
     * @return class-string<T>
     */
    public function getName(): string;
}
