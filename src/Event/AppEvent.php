<?php

declare(strict_types=1);

namespace Serafim\Boson\Event;

use Serafim\Boson\ApplicationInterface;

/**
 * @template-extends Event<ApplicationInterface>
 */
abstract class AppEvent extends Event
{
    public function __construct(ApplicationInterface $subject)
    {
        parent::__construct($subject);
    }
}
