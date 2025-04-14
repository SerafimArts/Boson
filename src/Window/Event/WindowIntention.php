<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Event;

use Serafim\Boson\Dispatcher\Intention;
use Serafim\Boson\Window\Window;

/**
 * @template-extends Intention<Window>
 */
abstract class WindowIntention extends Intention
{
    public function __construct(Window $subject, ?int $time = null)
    {
        parent::__construct($subject, $time);
    }
}
