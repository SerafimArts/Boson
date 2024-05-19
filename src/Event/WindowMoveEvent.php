<?php

declare(strict_types=1);

namespace Serafim\Boson\Event;

use Serafim\Boson\WindowInterface;

final class WindowMoveEvent extends WindowEvent
{
    public function __construct(
        WindowInterface $target,
        public readonly int $x = 0,
        public readonly int $y = 0,
    ) {
        parent::__construct($target);
    }

    public function __toString(): string
    {
        return \vsprintf('%s { x: %d, y: %d }', [
            self::class,
            $this->x,
            $this->y,
        ]);
    }
}
