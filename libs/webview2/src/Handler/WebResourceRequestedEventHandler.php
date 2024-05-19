<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use Local\Com\Attribute\MapStruct;

/**
 * @template-extends EventHandler<mixed>
 */
#[MapStruct(name: 'ICoreWebView2WebResourceRequestedEventHandler')]
final class WebResourceRequestedEventHandler extends EventHandler {}
