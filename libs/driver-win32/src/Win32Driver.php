<?php

declare(strict_types=1);

namespace Local\Driver\Win32;

use Serafim\Boson\Driver;
use Serafim\Boson\Window\CreateInfo;

final class Win32Driver extends Driver
{
    private ?Win32Environment $env = null;

    public function supports(): bool
    {
        return \PHP_OS_FAMILY === 'Windows';
    }

    private function getCurrentEnvironment(): Win32Environment
    {
        return $this->env ??= new Win32Environment($this->events, $this->bootstrap);
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

    public function isRunning(): bool
    {
        $environment = $this->getCurrentEnvironment();

        return $environment->isRunning();
    }

    public function stop(): void
    {
        $environment = $this->getCurrentEnvironment();
        $environment->stop();
    }
}
