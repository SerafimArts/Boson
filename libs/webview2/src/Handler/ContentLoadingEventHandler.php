<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use Local\Com\Attribute\MapStruct;

/**
 * @template-extends EventHandler<mixed>
 */
#[MapStruct(name: 'ICoreWebView2ContentLoadingEventHandler')]
final class ContentLoadingEventHandler extends EventHandler {}
