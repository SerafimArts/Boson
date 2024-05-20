<?php

declare(strict_types=1);

namespace Serafim\Boson\Event;

use Serafim\Boson\WindowInterface;

/**
 * Events that happen on any window events.
 *
 * @template-extends Event<WindowInterface>
 */
abstract class WindowEvent extends Event
{
    public function __construct(WindowInterface $subject)
    {
        parent::__construct($subject);
    }
}
