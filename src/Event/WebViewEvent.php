<?php

declare(strict_types=1);

namespace Serafim\Boson\Event;

use Serafim\Boson\Window\WebViewInterface;

/**
 * @template-extends Event<WebViewInterface>
 */
abstract class WebViewEvent extends Event
{
    public function __construct(WebViewInterface $subject)
    {
        parent::__construct($subject);
    }
}
