<?php

declare(strict_types=1);

namespace Serafim\Boson;

use Serafim\Boson\Window\CreateInfo;

interface ApplicationInterface extends RunnableInterface
{
    /**
     * Method for creating an application window.
     *
     * During window creation, you can specify additional window-specific
     * information using the {@see WindowCreateInfo} DTO class.
     */
    public function create(CreateInfo $info = new CreateInfo()): WindowInterface;
}
