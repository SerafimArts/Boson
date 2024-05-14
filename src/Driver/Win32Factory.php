<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver;

use Serafim\WinUI\CreateInfo;
use Serafim\WinUI\Driver\Win32\Handle\Win32ClassHandleFactory;
use Serafim\WinUI\Driver\Win32\Handle\Win32InstanceHandleFactory;
use Serafim\WinUI\Driver\Win32\Handle\Win32WindowHandleFactory;
use Serafim\WinUI\Driver\Win32\Lib\CoInit;
use Serafim\WinUI\Driver\Win32\Lib\Ole32;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;
use Serafim\WinUI\Driver\Win32\WebView2\InstallationDetector;
use Serafim\WinUI\Driver\Win32\Win32Window;

final class Win32Factory extends Driver
{
    public function supports(): bool
    {
        return \PHP_OS_FAMILY === 'Windows';
    }

    protected function onBoot(): void
    {
        // Detect WebView2 installation
        $installation = new InstallationDetector();
        $installation->assertIsInstalledOrFail();

        // Initializes the COM library for use by the calling thread
        $ole32 = Ole32::getInstance();
        $ole32->CoInitializeEx(null, CoInit::COINIT_APARTMENTTHREADED);
    }

    protected function onRelease(): void
    {
        $ole32 = Ole32::getInstance();
        $ole32->CoUninitialize();
    }

    public function create(CreateInfo $info = new CreateInfo()): Win32Window
    {
        $this->bootIfNotBooted();

        return new Win32Window(
            events: $this->events,
            info: $info,
            webview: WebView2::getInstance(),
            modules: new Win32InstanceHandleFactory(),
            classes: new Win32ClassHandleFactory($this->events),
            windows: new Win32WindowHandleFactory(),
        );
    }
}
