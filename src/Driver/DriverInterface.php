<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver;

use Serafim\WinUI\FactoryInterface;

interface DriverInterface extends FactoryInterface
{
    /**
     * Returns {@see true} in case of current runtime
     * environment supports by this factory.
     */
    public function supports(): bool;
}
