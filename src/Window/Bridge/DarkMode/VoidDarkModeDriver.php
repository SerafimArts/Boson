<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Bridge\DarkMode;

final readonly class VoidDarkModeDriver implements DarkModeDriverInterface
{
    public function enable(bool $enable = true): void
    {
        // Do nothing
    }
}
