<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32;

use Serafim\WinUI\Property\Property;
use Serafim\WinUI\Property\PropertyProviderTrait;
use Serafim\WinUI\Window\PositionInterface;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\WinUI\Driver
 */
final class Win32Position implements PositionInterface
{
    use PropertyProviderTrait;

    public const int CW_USER_DEFAULT = 0x8000_0000;

    public function __construct(
        private readonly Win32Rect $rect,
    ) {}

    public function set(PositionInterface $position): void
    {
        // @phpstan-ignore-next-line
        $this->rect->move($position->x, $position->y);
    }

    public function center(): void
    {
        $rect = $this->rect->get();

        $width = $this->rect->getScreenWidth();
        $height = $this->rect->getScreenHeight();

        $this->rect->move(
            x: (int) (($width - $rect->right) / 2),
            y: (int) (($height - $rect->bottom) / 2),
        );
    }

    /**
     * @return Property<int, int>
     */
    protected function x(): Property
    {
        return Property::new(
            get: function (): int {
                $rect = $this->rect->get();
                return $rect->left;
            },
            set: function (int $x): void {
                $this->rect->move(x: $x);
            }
        );
    }

    /**
     * @return Property<int, int>
     */
    protected function y(): Property
    {
        return Property::new(
            get: function (): int {
                $rect = $this->rect->get();
                return $rect->top;
            },
            set: function (int $y): void {
                $this->rect->move(y: $y);
            }
        );
    }

    public function __toString(): string
    {
        $rect = $this->rect->get();

        return \sprintf('%d×%d', $rect->left, $rect->top);
    }
}
