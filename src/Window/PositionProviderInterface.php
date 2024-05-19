<?php

declare(strict_types=1);

namespace Serafim\WinUI\Window;

/**
 * @property-read int $x
 * @property-read int $y
 */
interface PositionProviderInterface extends \Stringable
{
    /**
     * Returns string representation of the position object.
     *
     * @return non-empty-string
     */
    public function __toString(): string;
}
