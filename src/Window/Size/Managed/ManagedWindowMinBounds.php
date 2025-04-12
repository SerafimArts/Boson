<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Size\Managed;

use FFI\CData;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson\Window
 */
final class ManagedWindowMinBounds extends MemoizedManagedSize
{
    protected function getCurrentSizeValuesByRef(CData $width, CData $height): void
    {
        $this->api->saucer_window_min_size($this->handle, $width, $height);
    }

    protected function setSizeValues(int $width, int $height): void
    {
        $this->api->saucer_window_set_min_size($this->handle, $width, $height);
    }
}
