<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Event;

use Serafim\Boson\Dispatcher\Event;
use Serafim\Boson\WebView\WebView;

/**
 * @template-extends Event<WebView>
 */
abstract class WebViewEvent extends Event
{
    public function __construct(WebView $subject, ?int $time = null)
    {
        parent::__construct($subject, $time);
    }
}
