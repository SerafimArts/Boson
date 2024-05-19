<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Window;

use Local\Driver\Win32\Lib\SystemMetrics;
use Local\Driver\Win32\Lib\WindowPosition;
use Local\Property\Attribute\MapGetter;
use Local\Property\Attribute\MapSetter;
use Local\Property\ContainProperties;
use Serafim\WinUI\Window\Position;
use Serafim\WinUI\Window\PositionInterface;
use Serafim\WinUI\Window\PositionProviderInterface;

final class Win32Position extends WindowRectProvider implements PositionInterface
{
    use ContainProperties;

    private const int FLAG_SET_POSITION = WindowPosition::SWP_NOACTIVATE
        | WindowPosition::SWP_NOZORDER
        | WindowPosition::SWP_NOSIZE;

    public const int CW_USER_DEFAULT = 0x8000_0000;

    /**
     * @api
     */
    #[MapGetter('x')]
    public function getX(): int
    {
        $rect = $this->getRect();

        return $rect->left;
    }

    /**
     * @api
     */
    #[MapSetter('x')]
    public function setX(int $x): void
    {
        $this->set(new Position($x, $this->getY()));
    }

    /**
     * @api
     */
    #[MapGetter('y')]
    public function getY(): int
    {
        $rect = $this->getRect();

        return $rect->top;
    }

    /**
     * @api
     */
    #[MapSetter('y')]
    public function setY(int $y): void
    {
        $this->set(new Position($this->getX(), $y));
    }

    public function set(PositionProviderInterface $position): void
    {
        $this->user32->SetWindowPos(
            $this->window->handle->ptr,
            null,
            // @phpstan-ignore-next-line
            $position->x,
            // @phpstan-ignore-next-line
            $position->y,
            0,
            0,
            self::FLAG_SET_POSITION,
        );
    }

    /**
     * @return int<0, max>
     */
    private function getScreenWidth(): int
    {
        return $this->user32->GetSystemMetrics(SystemMetrics::SM_CXSCREEN);
    }

    /**
     * @return int<0, max>
     */
    private function getScreenHeight(): int
    {
        return $this->user32->GetSystemMetrics(SystemMetrics::SM_CYSCREEN);
    }

    public function center(): void
    {
        $rect = $this->getRect();

        $this->set(new Position(
            x: (int) (($this->getScreenWidth() - $rect->right) / 2),
            y: (int) (($this->getScreenHeight() - $rect->bottom) / 2)
        ));
    }

    public function __toString(): string
    {
        $rect = $this->getRect();

        return \vsprintf('Position(%d, %d)', [
            $rect->left,
            $rect->top,
        ]);
    }
}
