<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

final readonly class Size implements SizeProviderInterface
{
    public function __construct(
        public int $width = 0,
        public int $height = 0,
    ) {}

    public function __toString(): string
    {
        return \vsprintf('Size(%d, %d)', [
            $this->width,
            $this->height,
        ]);
    }
}
