<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use Local\Com\Attribute\MapStruct;

/**
 * TODO
 */
#[MapStruct(name: 'ICoreWebView2WebResourceRequestedEventArgs', owned: false)]
final class WebResourceRequestedEventArgs extends EventArgs {}
