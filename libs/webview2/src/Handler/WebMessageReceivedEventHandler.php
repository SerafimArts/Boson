<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use Local\Com\Attribute\MapStruct;
use Local\WebView2\Attribute\MapEventArgs;

/**
 * @template-extends EventHandler<mixed>
 */
#[MapEventArgs(class: WebMessageReceivedEventArgs::class)]
#[MapStruct(name: 'ICoreWebView2WebMessageReceivedEventHandler')]
final class WebMessageReceivedEventHandler extends EventHandler {}
