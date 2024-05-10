<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Managed\IUnknown;
use Serafim\WinUI\Driver\Win32\Managed\ManagedFunction;
use Serafim\WinUI\Driver\Win32\Managed\ManagedStruct;

#[ManagedStruct('ICoreWebView2CreateCoreWebView2ControllerCompletedHandler')]
final class ControllerCompletedHandler extends IUnknown
{
    /**
     * @param \Closure(CData):int $invoke
     */
    public function __construct(
        private readonly \Closure $invoke,
    ) {}

    #[ManagedFunction('Invoke')]
    public function __invoke(CData $self, int $error, ?CData $host): int
    {
        if ($error !== 0 || $host === null) {
            throw new \RuntimeException('Failed to create WebView Controller');
        }

        return ($this->invoke)($host);
    }
}
