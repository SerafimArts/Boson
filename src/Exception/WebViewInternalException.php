<?php

declare(strict_types=1);

namespace Serafim\Boson\Exception;

use Serafim\Boson\Core\Runtime\WebViewError;

class WebViewInternalException extends WebViewException
{
    /**
     * @param non-empty-string $when
     * @param WebViewError::WEBVIEW_ERROR_* $code
     */
    public static function becauseErrorOccurs(string $when, int $code, ?\Throwable $previous = null): self
    {
        $message = \sprintf('An internal error occurs while %s (0x%02X)', $when, $code);

        return new self($message, $code, $previous);
    }
}
