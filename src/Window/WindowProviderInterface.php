<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

interface WindowProviderInterface
{
    /**
     * Gets application window instance.
     */
    public WindowInterface $window { get; }
}
