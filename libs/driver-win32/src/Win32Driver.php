<?php

declare(strict_types=1);

namespace Local\Driver\Win32;

use Local\Driver\Win32\Win32\Win32Window;
use Serafim\WinUI\CreateInfo;
use Serafim\WinUI\Driver;

final class Win32Driver extends Driver
{
    private ?Win32Environment $env = null;

    public function supports(): bool
    {
        return \PHP_OS_FAMILY === 'Windows';
    }

    private function getCurrentEnvironment(): Win32Environment
    {
        return $this->env ??= new Win32Environment($this->events);
    }

    public function create(CreateInfo $info = new CreateInfo()): Win32Window
    {
        $environment = $this->getCurrentEnvironment();

        return $environment->create($info);
    }

    public function run(): void
    {
        $environment = $this->getCurrentEnvironment();
        $environment->run();
    }

    public function isRunnable(): bool
    {
        $environment = $this->getCurrentEnvironment();

        return $environment->isRunnable();
    }

    public function stop(): void
    {
        $environment = $this->getCurrentEnvironment();
        $environment->stop();
    }
}
