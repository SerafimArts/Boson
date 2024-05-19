<?php

declare(strict_types=1);

namespace Serafim\Boson;

interface ApplicationInterface extends RunnableInterface
{
    public function create(CreateInfo $info = new CreateInfo()): WindowInterface;
}
