<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

/**
 * @property-read int<0, max> $width
 * @property-read int<0, max> $height
 */
interface SizeProviderInterface extends \Stringable
{
    /**
     * Returns string representation of the size object.
     *
     * @return non-empty-string
     */
    public function __toString(): string;
}
