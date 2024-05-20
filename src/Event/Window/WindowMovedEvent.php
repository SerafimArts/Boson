<?php

declare(strict_types=1);

namespace Serafim\Boson\Event\Window;

use Serafim\Boson\Event\WindowEvent;
use Serafim\Boson\WindowInterface;

/**
 * Occurs after the window has been moved to another location.
 */
final class WindowMovedEvent extends WindowEvent
{
    public function __construct(
        WindowInterface $subject,
        public readonly int $x = 0,
        public readonly int $y = 0,
    ) {
        parent::__construct($subject);
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
