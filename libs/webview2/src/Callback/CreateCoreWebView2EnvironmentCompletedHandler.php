<?php

declare(strict_types=1);

namespace Local\WebView2\Callback;

use FFI\CData;
use Local\Com\Attribute\MapCallback;
use Local\Com\Attribute\MapStruct;
use Local\WebView2\Exception\ComNotInitializedException;
use Local\WebView2\ICoreWebView2Environment;

/**
 * @template-extends CallbackHandler<ICoreWebView2Environment>
 * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2createcorewebview2environmentcompletedhandler
 */
#[MapStruct(name: 'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler')]
final class CreateCoreWebView2EnvironmentCompletedHandler extends CallbackHandler
{
    private const int ERR_WINDOW_NOT_INITIALIZED = -2147221008;

    #[\Override, MapCallback('Invoke')]
    protected function onInvoke(CData $self, int $result, mixed $data): int
    {
        if ($result === self::ERR_WINDOW_NOT_INITIALIZED) {
            throw ComNotInitializedException::fromCode($result);
        }

        return parent::onInvoke($self, $result, $data);
    }
}
