<?php

declare(strict_types=1);

namespace Serafim\WinUI;

use Psr\EventDispatcher\EventDispatcherInterface;
use Serafim\WinUI\Driver\DriverInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

final class Factory implements FactoryInterface
{
    /**
     * @var list<DriverInterface>
     */
    private array $drivers = [];

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
        yield new Driver\Win32Factory();
    }

    private function select(): DriverInterface
    {
        foreach ($this->drivers as $driver) {
            if ($driver->supports()) {
                return $driver;
            }
        }

        throw new \RuntimeException('No suitable driver found');
    }

    public function create(CreateInfo $info = new CreateInfo()): WindowInterface
    {
        $driver = $this->select();

        return $driver->create($info);
    }
}
