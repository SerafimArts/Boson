<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Bridge\DarkMode;

/**
 * Driver that enables and disables dark mode
 *
 * @internal This is an internal library interface, please do not use it in your code
 * @psalm-internal Serafim\Boson\Window\Bridge
 */
interface DarkModeDriverInterface
{
    /**
     * Enables or disables dark mode
     */
    public function enable(bool $enable = true): void;
}
