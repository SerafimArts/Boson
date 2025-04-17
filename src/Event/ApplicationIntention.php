<?php

declare(strict_types=1);

namespace Serafim\Boson\Event;

use Serafim\Boson\Application;
use Serafim\Boson\Dispatcher\Intention;

/**
 * @template-extends Intention<Application>
 */
abstract class ApplicationIntention extends Intention
{
    public function __construct(Application $subject, ?int $time = null)
    {
        parent::__construct($subject, $time);
    }
}
