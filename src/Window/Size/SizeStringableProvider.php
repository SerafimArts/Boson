<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Size;

/**
 * @phpstan-require-implements SizeInterface
 * @mixin SizeInterface
 *
 * @internal This is an internal library trait, please do not use it in your code
 * @psalm-internal Serafim\Boson\Window
 */
trait SizeStringableProvider
{
    public function __toString(): string
    {
        return \vsprintf('Size(%d × %d)', [
            $this->width,
            $this->height,
        ]);
    }
}
