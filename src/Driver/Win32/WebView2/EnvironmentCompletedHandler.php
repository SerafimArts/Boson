<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Managed\IUnknown;
use Serafim\WinUI\Driver\Win32\Managed\ManagedFunction;
use Serafim\WinUI\Driver\Win32\Managed\ManagedStruct;

#[ManagedStruct(name: 'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler')]
final class EnvironmentCompletedHandler extends IUnknown
{
    /**
     * @param \Closure(CData):int $invoke
     */
    public function __construct(
        private readonly \Closure $invoke,
    ) {}

    #[ManagedFunction('Invoke')]
    public function __invoke(CData $self, int $error, CData $env): int
    {
        if ($error !== 0) {
            throw new \RuntimeException('Failed to create WebView Environment');
        }

        return ($this->invoke)($env);
    }
}
