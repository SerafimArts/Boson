<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Event;

use Serafim\Boson\Window\Window;

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
