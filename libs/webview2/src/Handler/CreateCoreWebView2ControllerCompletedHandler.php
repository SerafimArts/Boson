<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use Local\Com\Attribute\MapStruct;
use Local\WebView2\ICoreWebView2Controller;

/**
 * @template-extends Handler<ICoreWebView2Controller>
 * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2createcorewebview2controllercompletedhandler
 */
#[MapStruct(name: 'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler')]
final class CreateCoreWebView2ControllerCompletedHandler extends Handler {}
