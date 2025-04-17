<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Event;

use Serafim\Boson\Shared\Marker\AsWindowEvent;
use Serafim\Boson\Window\Window;

#[AsWindowEvent]
final class WindowDecorated extends WindowEvent
{
    public function __construct(
        Window $subject,
        public readonly bool $isDecorated,
        ?int $time = null
    ) {
        parent::__construct($subject, $time);
    }
}
