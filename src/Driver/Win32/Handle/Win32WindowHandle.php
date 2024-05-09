<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Handle;

use FFI\CData;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\WinUI\Driver\Win32
 */
final readonly class Win32WindowHandle extends Win32Handle
{
    public function __construct(
        public Win32ClassHandle $class,
        public CData $ptr,
    ) {}
}
