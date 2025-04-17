<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Manager;

use Serafim\Boson\Window\Window;
use Serafim\Boson\Window\WindowCreateInfo;

interface WindowFactoryInterface
{
    /**
     * Creates a new application window using passed optional configuration DTO.
     */
    public function create(WindowCreateInfo $info = new WindowCreateInfo()): Window;
}
