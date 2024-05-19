<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Window;

use FFI\CData;
use Local\Driver\Win32\Lib\User32;
use Local\Driver\Win32\Win32Window;

abstract class WindowRectProvider
{
    protected readonly CData $rect;

    public function __construct(
        protected readonly User32 $user32,
        protected readonly Win32Window $window,
    ) {
        // @phpstan-ignore-next-line
        $this->rect = $this->user32->new('RECT');
    }

    protected function getRect(): CData
    {
        $this->user32->GetWindowRect($this->window->handle->ptr, \FFI::addr($this->rect));

        return $this->rect;
    }
}
