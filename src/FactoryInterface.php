<?php

declare(strict_types=1);

namespace Serafim\WinUI;

interface FactoryInterface
{
    public function create(CreateInfo $info = new CreateInfo()): WindowInterface;
}
