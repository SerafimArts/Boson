<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use Local\Com\Attribute\MapStruct;
use Local\WebView2\Attribute\MapEventArgs;

/**
 * @template-extends EventHandler<WebResourceRequestedEventArgs>
 */
#[MapEventArgs(class: WebResourceRequestedEventArgs::class)]
#[MapStruct(name: 'ICoreWebView2WebResourceRequestedEventHandler')]
final class WebResourceRequestedEventHandler extends EventHandler {}
