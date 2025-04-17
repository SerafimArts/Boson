<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Event;

use Serafim\Boson\Shared\Marker\AsWebViewEvent;

#[AsWebViewEvent]
final class WebViewDomReady extends WebViewEvent {}
