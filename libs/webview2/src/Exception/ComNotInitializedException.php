<?php

declare(strict_types=1);

namespace Local\WebView2\Exception;

final class ComNotInitializedException extends WebViewException
{
    public static function fromCode(int $code): self
    {
        $message = \str_replace("\n", ' ', <<<'MESSAGE'
            The WebView2 environment cannot be created because the current
            process was not initialized as a COM library. Please call
            CoInitializeEx (or CoInitialize) before creating the environment:
            https://learn.microsoft.com/en-us/windows/win32/api/combaseapi/nf-combaseapi-coinitializeex
            MESSAGE);

        return new self($message, $code);
    }
}
