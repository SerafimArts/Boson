<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Window;

use Local\Driver\Win32\Lib\WindowPosition;
use Local\Property\Attribute\MapGetter;
use Local\Property\Attribute\MapSetter;
use Local\Property\ContainProperties;
use Serafim\Boson\Window\Size;
use Serafim\Boson\Window\SizeInterface;
use Serafim\Boson\Window\SizeProviderInterface;

final class Win32Size extends WindowRectProvider implements SizeInterface
{
    use ContainProperties;

    private const int FLAG_SET_SIZE = WindowPosition::SWP_NOACTIVATE
        | WindowPosition::SWP_NOZORDER
        | WindowPosition::SWP_NOOWNERZORDER
        | WindowPosition::SWP_NOMOVE;

    /**
     * @api
     * @return int<0, max>
     */
    #[MapGetter('width')]
    public function getWidth(): int
    {
        $rect = $this->getRect();

        /** @var int<0, max> */
        return \max(0, $rect->right - $rect->left);
    }

    /**
     * @api
     * @param int<0, max> $width
     */
    #[MapSetter('width')]
    public function setWidth(int $width): void
    {
        $this->set(new Size(
            width: \max(0, $width),
            height: $this->getHeight()
        ));
    }

    /**
     * @api
     * @return int<0, max>
     */
    #[MapGetter('height')]
    public function getHeight(): int
    {
        $rect = $this->getRect();

        /** @var int<0, max> */
        return \max(0, $rect->bottom - $rect->top);
    }

    /**
     * @api
     * @param int<0, max> $height
     */
    #[MapSetter('height')]
    public function setHeight(int $height): void
    {
        $this->set(new Size(
            width: $this->getWidth(),
            height: \max(0, $height),
        ));
    }

    public function set(SizeProviderInterface $size): void
    {
        $this->user32->SetWindowPos(
            $this->window->handle->ptr,
            null,
            0,
            0,
            // @phpstan-ignore-next-line
            $size->width,
            // @phpstan-ignore-next-line
            $size->height,
            self::FLAG_SET_SIZE,
        );
    }

    public function __toString(): string
    {
        $rect = $this->getRect();

        return \vsprintf('Size(%d, %d)', [
            $rect->right - $rect->left,
            $rect->bottom - $rect->top,
        ]);
    }
}
