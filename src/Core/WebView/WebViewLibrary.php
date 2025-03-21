<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\WebView;

use FFI\Env\Runtime;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson
 */
final readonly class WebViewLibrary
{
    public \FFI $ffi;

    /**
     * @param non-empty-string $library
     */
    public function __construct(string $library)
    {
        Runtime::assertAvailable();

        $this->ffi = \FFI::cdef(self::getHeaders(), $library);
    }

    /**
     * @return non-empty-string
     */
    private static function getHeaders(): string
    {
        /** @var non-empty-string $headers */
        static $headers = \file_get_contents(__FILE__, offset: __COMPILER_HALT_OFFSET__);

        return $headers;
    }

    /**
     * @param non-empty-string $method
     * @param array<non-empty-string|int<0, max>, mixed> $args
     */
    public function __call(string $method, array $args): mixed
    {
        // @phpstan-ignore-next-line : Additional assertion
        assert($method !== '', 'Method name MUST not be empty');

        // @phpstan-ignore-next-line : Thx PHPStan, I know
        return $this->ffi->$method(...$args);
    }

    public function __serialize(): array
    {
        throw new \LogicException('Cannot serialize WebView library');
    }

    public function __clone()
    {
        throw new \LogicException('Cannot clone WebView library');
    }
}

__halt_compiler();

/// Holds the elements of a MAJOR.MINOR.PATCH version number.
typedef struct {
  /// Major version.
  unsigned int major;
  /// Minor version.
  unsigned int minor;
  /// Patch version.
  unsigned int patch;
} webview_version_t;

/// Holds the library's version information.
typedef struct {
  /// The elements of the version number.
  webview_version_t version;
  /// SemVer 2.0.0 version number in MAJOR.MINOR.PATCH format.
  char version_number[32];
  /// SemVer 2.0.0 pre-release labels prefixed with "-" if specified, otherwise
  /// an empty string.
  char pre_release[48];
  /// SemVer 2.0.0 build metadata prefixed with "+", otherwise an empty string.
  char build_metadata[48];
} webview_version_info_t;

/// Pointer to a webview instance.
typedef void *webview_t;

/// Native handle kind. The actual type depends on the backend.
typedef enum {
  /// Top-level window. @c GtkWindow pointer (GTK), @c NSWindow pointer (Cocoa)
  /// or @c HWND (Win32).
  WEBVIEW_NATIVE_HANDLE_KIND_UI_WINDOW,
  /// Browser widget. @c GtkWidget pointer (GTK), @c NSView pointer (Cocoa) or
  /// @c HWND (Win32).
  WEBVIEW_NATIVE_HANDLE_KIND_UI_WIDGET,
  /// Browser controller. @c WebKitWebView pointer (WebKitGTK), @c WKWebView
  /// pointer (Cocoa/WebKit) or @c ICoreWebView2Controller pointer
  /// (Win32/WebView2).
  WEBVIEW_NATIVE_HANDLE_KIND_BROWSER_CONTROLLER
} webview_native_handle_kind_t;

/// Window size hints
typedef enum {
  /// Width and height are default size.
  WEBVIEW_HINT_NONE,
  /// Width and height are minimum bounds.
  WEBVIEW_HINT_MIN,
  /// Width and height are maximum bounds.
  WEBVIEW_HINT_MAX,
  /// Window size can not be changed by a user.
  WEBVIEW_HINT_FIXED
} webview_hint_t;

/**
 * @brief Error codes returned to callers of the API.
 *
 * The following codes are commonly used in the library:
 * - @c WEBVIEW_ERROR_OK
 * - @c WEBVIEW_ERROR_UNSPECIFIED
 * - @c WEBVIEW_ERROR_INVALID_ARGUMENT
 * - @c WEBVIEW_ERROR_INVALID_STATE
 *
 * With the exception of @c WEBVIEW_ERROR_OK which is normally expected,
 * the other common codes do not normally need to be handled specifically.
 * Refer to specific functions regarding handling of other codes.
 */
typedef enum {
  /// Missing dependency.
  WEBVIEW_ERROR_MISSING_DEPENDENCY = -5,
  /// Operation canceled.
  WEBVIEW_ERROR_CANCELED = -4,
  /// Invalid state detected.
  WEBVIEW_ERROR_INVALID_STATE = -3,
  /// One or more invalid arguments have been specified e.g. in a function call.
  WEBVIEW_ERROR_INVALID_ARGUMENT = -2,
  /// An unspecified error occurred. A more specific error code may be needed.
  WEBVIEW_ERROR_UNSPECIFIED = -1,
  /// OK/Success. Functions that return error codes will typically return this
  /// to signify successful operations.
  WEBVIEW_ERROR_OK = 0,
  /// Signifies that something already exists.
  WEBVIEW_ERROR_DUPLICATE = 1,
  /// Signifies that something does not exist.
  WEBVIEW_ERROR_NOT_FOUND = 2
} webview_error_t;

/**
 * Creates a new webview instance.
 *
 * @param debug Enable developer tools if supported by the backend.
 * @param window Optional native window handle, i.e. @c GtkWindow pointer
 *        @c NSWindow pointer (Cocoa) or @c HWND (Win32). If non-null,
 *        the webview widget is embedded into the given window, and the
 *        caller is expected to assume responsibility for the window as
 *        well as application lifecycle. If the window handle is null,
 *        a new window is created and both the window and application
 *        lifecycle are managed by the webview instance.
 * @remark Win32: The function also accepts a pointer to @c HWND (Win32) in the
 *         window parameter for backward compatibility.
 * @remark Win32/WebView2: @c CoInitializeEx should be called with
 *         @c COINIT_APARTMENTTHREADED before attempting to call this function
 *         with an existing window. Omitting this step may cause WebView2
 *         initialization to fail.
 * @return @c NULL on failure. Creation can fail for various reasons such
 *         as when required runtime dependencies are missing or when window
 *         creation fails.
 * @retval WEBVIEW_ERROR_MISSING_DEPENDENCY
 *         May be returned if WebView2 is unavailable on Windows.
 */
webview_t webview_create(int debug, void *window);

/**
 * Destroys a webview instance and closes the native window.
 *
 * @param w The webview instance.
 */
webview_error_t webview_destroy(webview_t w);

/**
 * Runs the main loop until it's terminated.
 *
 * @param w The webview instance.
 */
webview_error_t webview_run(webview_t w);

/**
 * Stops the main loop. It is safe to call this function from another other
 * background thread.
 *
 * @param w The webview instance.
 */
webview_error_t webview_terminate(webview_t w);

/**
 * Schedules a function to be invoked on the thread with the run/event loop.
 * Use this function e.g. to interact with the library or native handles.
 *
 * @param w The webview instance.
 * @param fn The function to be invoked.
 * @param arg An optional argument passed along to the callback function.
 */
webview_error_t webview_dispatch(webview_t w,
                                 void (*fn)(webview_t w, void *arg),
                                 void *arg);

/**
 * Returns the native handle of the window associated with the webview instance.
 * The handle can be a @c GtkWindow pointer (GTK), @c NSWindow pointer (Cocoa)
 * or @c HWND (Win32).
 *
 * @param w The webview instance.
 * @return The handle of the native window.
 */
void *webview_get_window(webview_t w);

/**
 * Get a native handle of choice.
 *
 * @param w The webview instance.
 * @param kind The kind of handle to retrieve.
 * @return The native handle or @c NULL.
 * @since 0.11
 */
void *webview_get_native_handle(webview_t w,
                                webview_native_handle_kind_t kind);

/**
 * Updates the title of the native window.
 *
 * @param w The webview instance.
 * @param title The new title.
 */
webview_error_t webview_set_title(webview_t w, const char *title);

/**
 * Updates the size of the native window.
 *
 * Remarks:
 * - Using WEBVIEW_HINT_MAX for setting the maximum window size is not
 *   supported with GTK 4 because X11-specific functions such as
 *   gtk_window_set_geometry_hints were removed. This option has no effect
 *   when using GTK 4.
 *
 * @param w The webview instance.
 * @param width New width.
 * @param height New height.
 * @param hints Size hints.
 */
webview_error_t webview_set_size(webview_t w, int width, int height,
                                 webview_hint_t hints);

/**
 * Navigates webview to the given URL. URL may be a properly encoded data URI.
 *
 * Example:
 * @code{.c}
 * webview_navigate(w, "https://github.com/webview/webview");
 * webview_navigate(w, "data:text/html,%3Ch1%3EHello%3C%2Fh1%3E");
 * webview_navigate(w, "data:text/html;base64,PGgxPkhlbGxvPC9oMT4=");
 * @endcode
 *
 * @param w The webview instance.
 * @param url URL.
 */
webview_error_t webview_navigate(webview_t w, const char *url);

/**
 * Load HTML content into the webview.
 *
 * Example:
 * @code{.c}
 * webview_set_html(w, "<h1>Hello</h1>");
 * @endcode
 *
 * @param w The webview instance.
 * @param html HTML content.
 */
webview_error_t webview_set_html(webview_t w, const char *html);

/**
 * Injects JavaScript code to be executed immediately upon loading a page.
 * The code will be executed before @c window.onload.
 *
 * @param w The webview instance.
 * @param js JS content.
 */
webview_error_t webview_init(webview_t w, const char *js);

/**
 * Evaluates arbitrary JavaScript code.
 *
 * Use bindings if you need to communicate the result of the evaluation.
 *
 * @param w The webview instance.
 * @param js JS content.
 */
webview_error_t webview_eval(webview_t w, const char *js);

/**
 * Binds a function pointer to a new global JavaScript function.
 *
 * Internally, JS glue code is injected to create the JS function by the
 * given name. The callback function is passed a request identifier,
 * a request string and a user-provided argument. The request string is
 * a JSON array of the arguments passed to the JS function.
 *
 * @param w The webview instance.
 * @param name Name of the JS function.
 * @param fn Callback function.
 * @param arg User argument.
 * @retval WEBVIEW_ERROR_DUPLICATE
 *         A binding already exists with the specified name.
 */
webview_error_t webview_bind(webview_t w, const char *name,
                             void (*fn)(const char *id,
                                        const char *req, void *arg),
                             void *arg);

/**
 * Removes a binding created with webview_bind().
 *
 * @param w The webview instance.
 * @param name Name of the binding.
 * @retval WEBVIEW_ERROR_NOT_FOUND No binding exists with the specified name.
 */
webview_error_t webview_unbind(webview_t w, const char *name);

/**
 * Responds to a binding call from the JS side.
 *
 * @param w The webview instance.
 * @param id The identifier of the binding call. Pass along the value received
 *           in the binding handler (see webview_bind()).
 * @param status A status of zero tells the JS side that the binding call was
 *               succesful; any other value indicates an error.
 * @param result The result of the binding call to be returned to the JS side.
 *               This must either be a valid JSON value or an empty string for
 *               the primitive JS value @c undefined.
 */
webview_error_t webview_return(webview_t w, const char *id,
                               int status, const char *result);

/**
 * Get the library's version information.
 *
 * @since 0.10
 */
const webview_version_info_t *webview_version(void);
