<?php

declare(strict_types=1);

namespace Serafim\WinUI;

interface ApplicationInterface extends RunnableInterface
{
    public function create(CreateInfo $info = new CreateInfo()): WindowInterface;
}
