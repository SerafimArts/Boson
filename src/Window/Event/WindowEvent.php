<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Event;

use Serafim\Boson\Dispatcher\Event;
use Serafim\Boson\Window\Window;

/**
 * @template-extends Event<Window>
 */
abstract class WindowEvent extends Event
{
    public function __construct(Window $subject, ?int $time = null)
    {
        parent::__construct($subject, $time);
    }
}
