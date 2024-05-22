<?php

declare(strict_types=1);

namespace Local\WebView2;

use Local\Com\Attribute\MapStruct;
use Local\WebView2\Shared\IUnknown;

#[MapStruct('ICoreWebView2WebResourceRequest', owned: true)]
final class ICoreWebView2WebResourceRequest extends IUnknown {}
