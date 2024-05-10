<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver;

use FFI\CData;
use Serafim\WinUI\CreateInfo;
use Serafim\WinUI\Driver\Win32\Handle\Win32ClassHandleFactory;
use Serafim\WinUI\Driver\Win32\Handle\Win32InstanceHandleFactory;
use Serafim\WinUI\Driver\Win32\Handle\Win32WindowHandleFactory;
use Serafim\WinUI\Driver\Win32\Lib\CoInit;
use Serafim\WinUI\Driver\Win32\Lib\Ole32;
use Serafim\WinUI\Driver\Win32\WebView2\WebView2Factory;
use Serafim\WinUI\Driver\Win32\Win32Window;

final class Win32Factory implements DriverInterface
{
    private bool $booted = false;

    public function supports(): bool
    {
        return \PHP_OS_FAMILY === 'Windows';
    }

    private function bootOle32IfNotBooted(): void
    {
        if ($this->booted === false) {
            $ole32 = Ole32::getInstance();
            $ole32->CoInitializeEx(null, CoInit::COINIT_APARTMENTTHREADED);

            $this->booted = true;
        }
    }

    public function create(CreateInfo $info = new CreateInfo()): Win32Window
    {
        $this->bootOle32IfNotBooted();

        return new Win32Window(
            info: $info,
            modules: new Win32InstanceHandleFactory(),
            classes: new Win32ClassHandleFactory(),
            windows: new Win32WindowHandleFactory(),
            webview: new WebView2Factory(),
        );
    }

    public function __destruct()
    {
        if ($this->booted) {
           $ole32 = Ole32::getInstance();
           $ole32->CoUninitialize();
        }
    }
}
