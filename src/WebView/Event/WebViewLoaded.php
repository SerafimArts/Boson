<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Event;

use Serafim\Boson\Internal\AsWebViewEvent;

#[AsWebViewEvent]
final class WebViewLoaded extends WebViewEvent {}
