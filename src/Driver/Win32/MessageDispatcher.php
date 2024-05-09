<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Handle\Win32WindowHandle;
use Serafim\WinUI\Driver\Win32\Lib\User32;

final readonly class MessageDispatcher
{
    private CData $message;

    private User32 $user32;

    public function __construct(
        ?User32 $user32 = null,
    ) {
        $this->user32 = $user32 ?? User32::getInstance();

        // @phpstan-ignore-next-line
        $this->message = $this->user32->new('MSG', false);
    }

    public function peek(Win32WindowHandle $handle): ?CData
    {
        $ptr = \FFI::addr($this->message);

        if ($this->user32->PeekMessageW($ptr, $handle->ptr, 0, 0, 1)) {
            $this->user32->TranslateMessage($ptr);
            $this->user32->DispatchMessageW($ptr);

            return $this->message;
        }

        return null;
    }
}
