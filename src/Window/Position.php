<?php

declare(strict_types=1);

namespace Serafim\WinUI\Window;

final readonly class Position implements PositionProviderInterface
{
    public function __construct(
        public int $x = 0,
        public int $y = 0,
    ) {}

    public function __toString(): string
    {
        return \vsprintf('Position(%d, %d)', [
            $this->x,
            $this->y,
        ]);
    }
}
