<?php

declare(strict_types=1);

namespace Serafim\WinUI\Window;

/**
 * @property int $x
 * @property int $y
 */
interface PositionInterface extends PositionProviderInterface
{
    /**
     * Center the window horizontally and vertically.
     */
    public function center(): void;

    public function set(PositionProviderInterface $position): void;
}
