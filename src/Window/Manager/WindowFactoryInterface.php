<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Manager;

use Serafim\Boson\Window\WindowCreateInfo;
use Serafim\Boson\Window\WindowInterface;

interface WindowFactoryInterface
{
    /**
     * Creates a new application window.
     */
    public function create(WindowCreateInfo $info = new WindowCreateInfo()): WindowInterface;
}
