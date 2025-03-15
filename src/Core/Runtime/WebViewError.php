<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Runtime;

/**
 * Error codes returned to callers of the API.
 *
 * The following codes are commonly used in the library:
 * - {@see WebViewError::WEBVIEW_ERROR_OK}
 * - {@see WebViewError::WEBVIEW_ERROR_UNSPECIFIED}
 * - {@see WebViewError::WEBVIEW_ERROR_INVALID_ARGUMENT}
 * - {@see WebViewError::WEBVIEW_ERROR_INVALID_STATE}
 *
 * With the exception of {@see WebViewError::WEBVIEW_ERROR_OK} which is normally
 * expected, the other common codes do not normally need to be handled
 * specifically.
 *
 * Refer to specific functions regarding handling of other codes.
 *
 * @internal this is an internal library class, please do not use it in your code.
 * @psalm-internal Serafim\Boson\Core
 */
final readonly class WebViewError
{
    /**
     * Missing dependency.
     */
    public const int WEBVIEW_ERROR_MISSING_DEPENDENCY = -5;

    /**
     * Operation canceled.
     */
    public const int WEBVIEW_ERROR_CANCELED = -4;

    /**
     * Invalid state detected.
     */
    public const int WEBVIEW_ERROR_INVALID_STATE = -3;

    /**
     * One or more invalid arguments have been specified e.g. in a function call.
     */
    public const int WEBVIEW_ERROR_INVALID_ARGUMENT = -2;

    /**
     * An unspecified error occurred. A more specific error code may be needed.
     */
    public const int WEBVIEW_ERROR_UNSPECIFIED = -1;

    /**
     * OK/Success. Functions that return error codes will typically return
     * this to signify successful operations.
     */
    public const int WEBVIEW_ERROR_OK = 0;

    /**
     * Signifies that something already exists.
     */
    public const int WEBVIEW_ERROR_DUPLICATE = 1;

    /**
     * Signifies that something does not exist.
     */
    public const int WEBVIEW_ERROR_NOT_FOUND = 2;

    private function __construct() {}
}
