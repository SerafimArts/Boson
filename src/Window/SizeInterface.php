<?php

declare(strict_types=1);

namespace Serafim\WinUI\Window;

/**
 * @property int<0, max> $width
 * @property int<0, max> $height
 */
interface SizeInterface extends \Stringable
{
    public function set(self $size): void;

    /**
     * Returns string representation of the size object.
     *
     * @return non-empty-string
     */
    public function __toString(): string;
}
