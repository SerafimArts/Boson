<?php

declare(strict_types=1);

namespace Local\WebView2\Callback;

use Local\Com\Attribute\MapStruct;

/**
 * @template-extends CallbackHandler<string>
 */
#[MapStruct(name: 'ICoreWebView2ExecuteScriptCompletedHandler')]
final class ExecuteScriptCompletedHandler extends CallbackHandler {}
