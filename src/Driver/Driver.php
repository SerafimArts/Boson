<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver;

use Psr\EventDispatcher\EventDispatcherInterface;

abstract class Driver implements DriverInterface
{
    private bool $booted = false;

    public function __construct(
        protected readonly EventDispatcherInterface $events,
    ) {}

    protected function bootIfNotBooted(): void
    {
        if ($this->booted === false) {
            $this->booted = true;
            $this->onBoot();
        }
    }

    protected function onBoot(): void
    {
    }

    protected function onRelease(): void
    {
    }

    public function __destruct()
    {
        if ($this->booted === true) {
            $this->booted = false;
            $this->onRelease();
        }
    }
}
