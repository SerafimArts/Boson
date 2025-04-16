<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Event;

use Serafim\Boson\Internal\AsWindowEvent;
use Serafim\Boson\Window\Window;

#[AsWindowEvent]
final class WindowFocused extends WindowEvent
{
    public function __construct(
        Window $subject,
        public readonly bool $isFocused,
        ?int $time = null
    ) {
        parent::__construct($subject, $time);
    }
}
