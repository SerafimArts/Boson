<?php

declare(strict_types=1);

namespace Serafim\Boson;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class Driver implements DriverInterface
{
    public function __construct(
        protected readonly EventDispatcherInterface $events,
    ) {}
}
