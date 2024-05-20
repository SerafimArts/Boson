<?php

declare(strict_types=1);

namespace Serafim\Boson\Event\Window;

use Serafim\Boson\Event\WindowEvent;
use Serafim\Boson\WindowInterface;

/**
 * Occurs after the window has been resized.
 */
final class WindowResizeEvent extends WindowEvent
{
    /**
     * @param int<0, max> $width
     * @param int<0, max> $height
     */
    public function __construct(
        WindowInterface $subject,
        public readonly int $width = 0,
        public readonly int $height = 0,
    ) {
        parent::__construct($subject);
    }

    public function __toString(): string
    {
        return \vsprintf('%s { width: %d, height: %d }', [
            self::class,
            $this->width,
            $this->height,
        ]);
    }
}
