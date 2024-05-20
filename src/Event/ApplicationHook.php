<?php

declare(strict_types=1);

namespace Serafim\Boson\Event;

use Serafim\Boson\ApplicationInterface;

/**
 * @template-extends Hook<ApplicationInterface>
 */
abstract class ApplicationHook extends Hook
{
    public function __construct(ApplicationInterface $subject)
    {
        parent::__construct($subject);
    }
}
