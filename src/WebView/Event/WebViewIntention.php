<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Event;

use Serafim\Boson\Dispatcher\Intention;
use Serafim\Boson\WebView\WebView;

/**
 * @template-extends Intention<WebView>
 */
abstract class WebViewIntention extends Intention
{
    public function __construct(WebView $subject, ?int $time = null)
    {
        parent::__construct($subject, $time);
    }
}
