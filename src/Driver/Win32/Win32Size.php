<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32;

use Serafim\WinUI\Property\Property;
use Serafim\WinUI\Property\PropertyProviderTrait;
use Serafim\WinUI\Window\SizeInterface;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\WinUI\Driver
 */
final class Win32Size implements SizeInterface
{
    use PropertyProviderTrait;

    public function __construct(
        private readonly Win32Rect $rect,
    ) {}

    public function set(SizeInterface $size): void
    {
        // @phpstan-ignore-next-line
        $this->rect->resize($size->width, $size->height);
    }

    /**
     * @return Property<int<0, max>, int<0, max>>
     */
    protected function width(): Property
    {
        // @phpstan-ignore-next-line
        return Property::new(
            get: function (): int {
                $rect = $this->rect->get();

                return $rect->right;
            },
            set: function (int $width): void {
                // @phpstan-ignore-next-line
                $this->rect->resize(width: $width);
            }
        );
    }

    /**
     * @return Property<int<0, max>, int<0, max>>
     */
    protected function height(): Property
    {
        // @phpstan-ignore-next-line
        return Property::new(
            get: function (): int {
                $rect = $this->rect->get();

                return $rect->bottom;
            },
            set: function (int $height): void {
                // @phpstan-ignore-next-line
                $this->rect->resize(height: $height);
            }
        );
    }

    public function __toString(): string
    {
        $rect = $this->rect->get();

        return \sprintf('%d×%d', $rect->right, $rect->bottom);
    }
}
