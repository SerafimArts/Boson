<?php

declare(strict_types=1);

namespace Serafim\Boson\Shared\Win32\DesktopWindowManager;

use FFI\CData;

/**
 * @phpstan-type HResultType int<-2147483648, 2147483647>
 * @phpstan-type WindowAttributeType DwmWindowAttribute::DWMWA_*|int<0, 4294967295>
 * @phpstan-type WindowAttributeSizeType int<0, 4294967295>
 * @phpstan-type WindowHandleType CData
 *
 * @mixin \FFI
 */
final readonly class LibDwmApi
{
    /**
     * @param WindowHandleType $hwnd
     * @param WindowAttributeType $dwAttribute
     * @param WindowAttributeSizeType $cbAttribute
     * @return HResultType
     */
    public function DwmSetWindowAttribute(
        CData $hwnd,
        int $dwAttribute,
        mixed $pvAttribute,
        int $cbAttribute,
    ): int {}
}
