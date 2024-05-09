<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver;

use Serafim\WinUI\CreateInfo;
use Serafim\WinUI\Driver\Win32\Handle\Win32ClassHandleFactory;
use Serafim\WinUI\Driver\Win32\Handle\Win32InstanceHandleFactory;
use Serafim\WinUI\Driver\Win32\Handle\Win32WindowHandleFactory;
use Serafim\WinUI\Driver\Win32\WebView2\InstallationDetector;
use Serafim\WinUI\Driver\Win32\Win32Window;

final class Win32Factory implements DriverInterface
{
    public function supports(): bool
    {
        return \PHP_OS_FAMILY === 'Windows';
    }

    /**
     * Check WebView2 is installed
     */
    private function assertIsInstalledOrFail(): void
    {
        $installation = new InstallationDetector();
        $installation->assertIsInstalledOrFail();
    }

    public function create(CreateInfo $info = new CreateInfo()): Win32Window
    {
        $this->assertIsInstalledOrFail();

        return new Win32Window(
            info: $info,
            modules: new Win32InstanceHandleFactory(),
            classes: new Win32ClassHandleFactory(),
            windows: new Win32WindowHandleFactory(),
        );
    }
}
