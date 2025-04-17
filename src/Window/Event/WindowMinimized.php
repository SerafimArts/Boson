<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Event;

use Serafim\Boson\Shared\Marker\AsWindowEvent;
use Serafim\Boson\Window\Window;

#[AsWindowEvent]
final class WindowMinimized extends WindowEvent
{
    public function __construct(
        Window $subject,
        public readonly bool $isMinimized,
        ?int $time = null,
    ) {
        parent::__construct($subject, $time);
    }
}
