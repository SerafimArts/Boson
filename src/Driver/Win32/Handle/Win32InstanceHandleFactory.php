<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Handle;

use Serafim\WinUI\Driver\Win32\Lib\Kernel32;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\WinUI\Driver\Win32
 */
final class Win32InstanceHandleFactory
{
    private ?Win32InstanceHandle $current = null;

    private readonly Kernel32 $kernel32;

    public function __construct(
        ?Kernel32 $kernel32 = null,
    ) {
        $this->kernel32 = $kernel32 ?? Kernel32::getInstance();
    }

    public function getCurrentInstanceHandle(): Win32InstanceHandle
    {
        return $this->current ??= new Win32InstanceHandle(
            ptr: $this->kernel32->GetModuleHandleA(null),
        );
    }
}
