<?php

declare(strict_types=1);

namespace Serafim\WinUI\Event;

use Serafim\WinUI\WindowInterface;

/**
 * @template-extends Event<WindowInterface>
 */
abstract class WindowEvent extends Event
{
    public function __construct(WindowInterface $target)
    {
        parent::__construct($target);
    }
}
