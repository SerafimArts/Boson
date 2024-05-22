<?php

declare(strict_types=1);

namespace Local\Dispatcher\Subscription;

use Local\Id\IdInterface;

/**
 * @template T of object
 * @template-implements SubscriptionInterface<T>
 */
class Subscription implements SubscriptionInterface
{
    /**
     * @param IdInterface<scalar> $id
     * @param class-string<T> $name
     */
    public function __construct(
        private readonly IdInterface $id,
        private readonly string $name,
    ) {}

    public function getId(): IdInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
