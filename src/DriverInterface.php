<?php

declare(strict_types=1);

namespace Serafim\Boson;

interface DriverInterface extends ApplicationInterface
{
    /**
     * Returns {@see true} in case of current runtime
     * environment supports by this factory.
     */
    public function supports(): bool;
}
