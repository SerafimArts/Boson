<?php

declare(strict_types=1);

namespace Serafim\WinUI;

use Local\Driver;
use Serafim\WinUI\Event\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Application implements ApplicationInterface
{
    /**
     * @var list<DriverInterface>
     */
    private array $drivers = [];

    private ?DriverInterface $current = null;

    /**
     * @param iterable<mixed, DriverInterface> $drivers
     */
    public function __construct(
        private readonly EventDispatcherInterface $events = new EventDispatcher(),
        iterable $drivers = [],
    ) {
        foreach ($drivers as $factory) {
            $this->drivers[] = $factory;
        }

        foreach ($this->getDefaultFactories() as $factory) {
            $this->drivers[] = $factory;
        }
    }

    /**
     * @template T of Event
     * @param class-string<T> $event
     * @param callable(T):void $listener
     */
    public function on(string $event, callable $listener): void
    {
        $this->events->addListener($event, $listener);
    }

    /**
     * @template T of Event
     * @param class-string<T> $event
     * @param callable(T):void $listener
     */
    public function off(string $event, callable $listener): void
    {
        $this->events->removeListener($event, $listener);
    }

    public function withDriver(DriverInterface $driver): self
    {
        $self = clone $this;
        $self->addDriver($driver);

        return $self;
    }

    public function addDriver(DriverInterface $driver): void
    {
        $this->drivers[] = $driver;
    }

    /**
     * @return iterable<array-key, DriverInterface>
     */
    private function getDefaultFactories(): iterable
    {
        yield new Driver\Win32\Win32Driver($this->events);
    }

    private function select(): DriverInterface
    {
        if ($this->current !== null) {
            return $this->current;
        }

        foreach ($this->drivers as $driver) {
            if ($driver->supports()) {
                return $this->current = $driver;
            }
        }

        throw new \RuntimeException('No suitable driver found');
    }

    public function create(CreateInfo $info = new CreateInfo()): WindowInterface
    {
        $driver = $this->select();
        return $driver->create($info);
    }

    public function run(): void
    {
        $driver = $this->select();
        $driver->run();
    }

    public function isRunnable(): bool
    {
        $driver = $this->select();
        return $driver->isRunnable();
    }

    public function stop(): void
    {
        $driver = $this->select();
        $driver->stop();
    }
}
