<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Win32;

use FFI\CData;
use Local\Driver\Win32\Handle\Win32WindowHandle;
use Local\Driver\Win32\Lib\SystemMetrics;
use Local\Driver\Win32\Lib\User32;
use Local\Driver\Win32\Lib\WindowPosition;

final readonly class Win32Rect
{
    /**
     * @var CData & object{
     *     right: int<0, max>,
     *     bottom: int<0, max>,
     *     left: int,
     *     top: int
     * }
     */
    private CData $rect;

    public function __construct(
        private User32 $user32,
        private Win32WindowHandle $handle,
    ) {
        // @phpstan-ignore-next-line
        $this->rect = $this->user32->new('RECT');
    }

    /**
     * @return int<0, max>
     */
    public function getScreenWidth(): int
    {
        return $this->user32->GetSystemMetrics(SystemMetrics::SM_CXSCREEN);
    }

    /**
     * @return int<0, max>
     */
    public function getScreenHeight(): int
    {
        return $this->user32->GetSystemMetrics(SystemMetrics::SM_CYSCREEN);
    }

    /**
     * @return CData & object{
     *     right: int<0, max>,
     *     bottom: int<0, max>,
     *     left: int,
     *     top: int
     * }
     */
    public function get(): CData
    {
        $this->user32->GetClientRect(
            $this->handle->ptr,
            \FFI::addr($this->rect),
        );

        return $this->rect;
    }

    /**
     * @param int<0, max>|null $width
     * @param int<0, max>|null $height
     */
    public function resize(?int $width = null, ?int $height = null): void
    {
        if ($width === null || $height === null) {
            $rect = $this->get();
            $width ??= $rect->right;
            $height ??= $rect->bottom;
        }

        $this->user32->SetWindowPos(
            $this->handle->ptr,
            null,
            0,
            0,
            $width,
            $height,
            WindowPosition::SWP_NOMOVE,
        );
    }

    public function move(?int $x = null, ?int $y = null): void
    {
        if ($x === null || $y === null) {
            $rect = $this->get();
            $x ??= $rect->left;
            $y ??= $rect->top;
        }

        $this->user32->SetWindowPos(
            $this->handle->ptr,
            null,
            $x,
            $y,
            0,
            0,
            WindowPosition::SWP_NOSIZE,
        );
    }
}
