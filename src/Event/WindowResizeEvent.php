<?php

declare(strict_types=1);

namespace Serafim\Boson\Event;

use Serafim\Boson\WindowInterface;

final class WindowResizeEvent extends WindowEvent
{
    /**
     * @param int<0, max> $width
     * @param int<0, max> $height
     */
    public function __construct(
        WindowInterface $target,
        public readonly int $width = 0,
        public readonly int $height = 0,
    ) {
        parent::__construct($target);
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
