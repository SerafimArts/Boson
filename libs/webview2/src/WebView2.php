<?php

declare(strict_types=1);

namespace Local\WebView2;

use FFI\CData;
use FFI\Env\Runtime;
use FFI\Proxy\Proxy;
use Local\Com\Exception\ResultException;
use Local\WebView2\Handler\CreateCoreWebView2EnvironmentCompletedHandler;

final class WebView2 extends Proxy
{
    private static ?WebView2 $instance = null;

    private function __construct()
    {
        Runtime::assertAvailable();

        parent::__construct(\FFI::cdef(
            code: self::getHeader(),
            lib: self::getLibraryPathname(),
        ));
    }

    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    /**
     * Creates an evergreen WebView2 Environment using the installed WebView2
     * Runtime version.
     *
     * @param callable(ICoreWebView2Environment):void $then
     * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/webview2-idl#createcorewebview2environment
     */
    public function createCoreWebView2Environment(callable $then): void
    {
        $handler = CreateCoreWebView2EnvironmentCompletedHandler::create(
            ffi: $this,
            callback: function (CData $ptr) use ($then): void {
                $then(new ICoreWebView2Environment($this, $ptr));
            },
        );

        /**
         * @var int $result
         * @phpstan-ignore-next-line
         */
        $result = $this->ffi->CreateCoreWebView2Environment(\FFI::addr($handler->cdata));

        if ($result !== 0) {
            throw ResultException::fromProcName('CreateCoreWebView2Environment', $result);
        }
    }

    /**
     * @return non-empty-string
     */
    private static function getLibraryPathname(): string
    {
        $directory = match (true) {
            self::isArm64() => 'arm64',
            \PHP_INT_SIZE === 4 => 'x86',
            default => 'x64',
        };

        return __DIR__ . '/../bin/win32/' . $directory . '/WebView2Loader.dll';
    }

    private static function isArm64(): bool
    {
        return \in_array(\php_uname('m'), ['arm64', 'aarch64'], true);
    }

    public static function getHeader(): string
    {
        return (string) \file_get_contents(__FILE__, offset: __COMPILER_HALT_OFFSET__);
    }
}

__halt_compiler();

typedef signed int INT32;
typedef signed long long INT64;
typedef unsigned int UINT32;
typedef unsigned long long UINT64;
typedef _Bool BOOL;
typedef unsigned char BYTE;
typedef unsigned int DWORD;
typedef char WCHAR; // wide char fix
typedef const WCHAR *PCWSTR;
typedef const WCHAR *LPCWSTR;
typedef WCHAR *LPWSTR;
typedef int LONG;
typedef unsigned int ULONG;
typedef int INT;
typedef unsigned int UINT;
typedef LONG HRESULT;
typedef void *PVOID;
typedef PVOID HANDLE;
typedef HANDLE HWND;
typedef HANDLE HICON;
typedef HICON HCURSOR;

typedef struct _GUID {
    unsigned int Data1;
    unsigned short Data2;
    unsigned short Data3;
    unsigned char Data4[8];
} GUID, IID;

typedef struct tagPOINT {
    LONG x;
    LONG y;
} POINT;

typedef struct tagRECT {
    LONG left;
    LONG top;
    LONG right;
    LONG bottom;
} RECT;

typedef struct IStream IStream;
typedef struct IUnknown IUnknown;
typedef struct tagVARIANT VARIANT;

typedef struct ICoreWebView2AcceleratorKeyPressedEventArgs ICoreWebView2AcceleratorKeyPressedEventArgs;
typedef struct ICoreWebView2AcceleratorKeyPressedEventHandler ICoreWebView2AcceleratorKeyPressedEventHandler;
typedef struct ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler;
typedef struct ICoreWebView2CallDevToolsProtocolMethodCompletedHandler ICoreWebView2CallDevToolsProtocolMethodCompletedHandler;
typedef struct ICoreWebView2CapturePreviewCompletedHandler ICoreWebView2CapturePreviewCompletedHandler;
typedef struct ICoreWebView2 ICoreWebView2;
typedef struct ICoreWebView2_2 ICoreWebView2_2;
typedef struct ICoreWebView2_3 ICoreWebView2_3;
typedef struct ICoreWebView2CompositionController ICoreWebView2CompositionController;
typedef struct ICoreWebView2CompositionController2 ICoreWebView2CompositionController2;
typedef struct ICoreWebView2Controller ICoreWebView2Controller;
typedef struct ICoreWebView2Controller2 ICoreWebView2Controller2;
typedef struct ICoreWebView2Controller3 ICoreWebView2Controller3;
typedef struct ICoreWebView2ContentLoadingEventArgs ICoreWebView2ContentLoadingEventArgs;
typedef struct ICoreWebView2ContentLoadingEventHandler ICoreWebView2ContentLoadingEventHandler;
typedef struct ICoreWebView2Cookie ICoreWebView2Cookie;
typedef struct ICoreWebView2CookieList ICoreWebView2CookieList;
typedef struct ICoreWebView2CookieManager ICoreWebView2CookieManager;
typedef struct ICoreWebView2CreateCoreWebView2CompositionControllerCompletedHandler ICoreWebView2CreateCoreWebView2CompositionControllerCompletedHandler;
typedef struct ICoreWebView2CreateCoreWebView2ControllerCompletedHandler ICoreWebView2CreateCoreWebView2ControllerCompletedHandler;
typedef struct ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler;
typedef struct ICoreWebView2ContainsFullScreenElementChangedEventHandler ICoreWebView2ContainsFullScreenElementChangedEventHandler;
typedef struct ICoreWebView2CursorChangedEventHandler ICoreWebView2CursorChangedEventHandler;
typedef struct ICoreWebView2DocumentTitleChangedEventHandler ICoreWebView2DocumentTitleChangedEventHandler;
typedef struct ICoreWebView2DOMContentLoadedEventArgs ICoreWebView2DOMContentLoadedEventArgs;
typedef struct ICoreWebView2DOMContentLoadedEventHandler ICoreWebView2DOMContentLoadedEventHandler;
typedef struct ICoreWebView2Deferral ICoreWebView2Deferral;
typedef struct ICoreWebView2DevToolsProtocolEventReceivedEventArgs ICoreWebView2DevToolsProtocolEventReceivedEventArgs;
typedef struct ICoreWebView2DevToolsProtocolEventReceivedEventHandler ICoreWebView2DevToolsProtocolEventReceivedEventHandler;
typedef struct ICoreWebView2DevToolsProtocolEventReceiver ICoreWebView2DevToolsProtocolEventReceiver;
typedef struct ICoreWebView2Environment ICoreWebView2Environment;
typedef struct ICoreWebView2Environment2 ICoreWebView2Environment2;
typedef struct ICoreWebView2Environment3 ICoreWebView2Environment3;
typedef struct ICoreWebView2Environment4 ICoreWebView2Environment4;
typedef struct ICoreWebView2EnvironmentOptions ICoreWebView2EnvironmentOptions;
typedef struct ICoreWebView2ExecuteScriptCompletedHandler ICoreWebView2ExecuteScriptCompletedHandler;
typedef struct ICoreWebView2FocusChangedEventHandler ICoreWebView2FocusChangedEventHandler;
typedef struct ICoreWebView2GetCookiesCompletedHandler ICoreWebView2GetCookiesCompletedHandler;
typedef struct ICoreWebView2HistoryChangedEventHandler ICoreWebView2HistoryChangedEventHandler;
typedef struct ICoreWebView2HttpHeadersCollectionIterator ICoreWebView2HttpHeadersCollectionIterator;
typedef struct ICoreWebView2HttpRequestHeaders ICoreWebView2HttpRequestHeaders;
typedef struct ICoreWebView2HttpResponseHeaders ICoreWebView2HttpResponseHeaders;
typedef struct ICoreWebView2Interop ICoreWebView2Interop;
typedef struct ICoreWebView2MoveFocusRequestedEventArgs ICoreWebView2MoveFocusRequestedEventArgs;
typedef struct ICoreWebView2MoveFocusRequestedEventHandler ICoreWebView2MoveFocusRequestedEventHandler;
typedef struct ICoreWebView2NavigationCompletedEventArgs ICoreWebView2NavigationCompletedEventArgs;
typedef struct ICoreWebView2NavigationCompletedEventHandler ICoreWebView2NavigationCompletedEventHandler;
typedef struct ICoreWebView2NavigationStartingEventArgs ICoreWebView2NavigationStartingEventArgs;
typedef struct ICoreWebView2NavigationStartingEventHandler ICoreWebView2NavigationStartingEventHandler;
typedef struct ICoreWebView2NewBrowserVersionAvailableEventHandler ICoreWebView2NewBrowserVersionAvailableEventHandler;
typedef struct ICoreWebView2NewWindowRequestedEventArgs ICoreWebView2NewWindowRequestedEventArgs;
typedef struct ICoreWebView2NewWindowRequestedEventHandler ICoreWebView2NewWindowRequestedEventHandler;
typedef struct ICoreWebView2PermissionRequestedEventArgs ICoreWebView2PermissionRequestedEventArgs;
typedef struct ICoreWebView2PermissionRequestedEventHandler ICoreWebView2PermissionRequestedEventHandler;
typedef struct ICoreWebView2PointerInfo ICoreWebView2PointerInfo;
typedef struct ICoreWebView2ProcessFailedEventArgs ICoreWebView2ProcessFailedEventArgs;
typedef struct ICoreWebView2ProcessFailedEventHandler ICoreWebView2ProcessFailedEventHandler;
typedef struct ICoreWebView2RasterizationScaleChangedEventHandler ICoreWebView2RasterizationScaleChangedEventHandler;
typedef struct ICoreWebView2ScriptDialogOpeningEventArgs ICoreWebView2ScriptDialogOpeningEventArgs;
typedef struct ICoreWebView2ScriptDialogOpeningEventHandler ICoreWebView2ScriptDialogOpeningEventHandler;
typedef struct ICoreWebView2Settings ICoreWebView2Settings;
typedef struct ICoreWebView2SourceChangedEventArgs ICoreWebView2SourceChangedEventArgs;
typedef struct ICoreWebView2SourceChangedEventHandler ICoreWebView2SourceChangedEventHandler;
typedef struct ICoreWebView2TrySuspendCompletedHandler ICoreWebView2TrySuspendCompletedHandler;
typedef struct ICoreWebView2WebMessageReceivedEventArgs ICoreWebView2WebMessageReceivedEventArgs;
typedef struct ICoreWebView2WebMessageReceivedEventHandler ICoreWebView2WebMessageReceivedEventHandler;
typedef struct ICoreWebView2WebResourceRequest ICoreWebView2WebResourceRequest;
typedef struct ICoreWebView2WebResourceRequestedEventArgs ICoreWebView2WebResourceRequestedEventArgs;
typedef struct ICoreWebView2WebResourceRequestedEventHandler ICoreWebView2WebResourceRequestedEventHandler;
typedef struct ICoreWebView2WebResourceResponse ICoreWebView2WebResourceResponse;
typedef struct ICoreWebView2WebResourceResponseReceivedEventHandler ICoreWebView2WebResourceResponseReceivedEventHandler;
typedef struct ICoreWebView2WebResourceResponseReceivedEventArgs ICoreWebView2WebResourceResponseReceivedEventArgs;
typedef struct ICoreWebView2WebResourceResponseView ICoreWebView2WebResourceResponseView;
typedef struct ICoreWebView2WebResourceResponseViewGetContentCompletedHandler ICoreWebView2WebResourceResponseViewGetContentCompletedHandler;
typedef struct ICoreWebView2WindowCloseRequestedEventHandler ICoreWebView2WindowCloseRequestedEventHandler;
typedef struct ICoreWebView2WindowFeatures ICoreWebView2WindowFeatures;
typedef struct ICoreWebView2ZoomFactorChangedEventHandler ICoreWebView2ZoomFactorChangedEventHandler;
typedef struct ICoreWebView2CompositionControllerInterop ICoreWebView2CompositionControllerInterop;
typedef struct ICoreWebView2EnvironmentInterop ICoreWebView2EnvironmentInterop;
struct EventRegistrationToken
{
    INT64 value;
};
typedef struct EventRegistrationToken EventRegistrationToken;
typedef enum COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT
{
    COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT_PNG = 0,
    COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT_JPEG = (COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT_PNG + 1)
} COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT;
typedef enum COREWEBVIEW2_COOKIE_SAME_SITE_KIND
{
    COREWEBVIEW2_COOKIE_SAME_SITE_KIND_NONE = 0,
    COREWEBVIEW2_COOKIE_SAME_SITE_KIND_LAX = (COREWEBVIEW2_COOKIE_SAME_SITE_KIND_NONE + 1),
    COREWEBVIEW2_COOKIE_SAME_SITE_KIND_STRICT = (COREWEBVIEW2_COOKIE_SAME_SITE_KIND_LAX + 1)
} COREWEBVIEW2_COOKIE_SAME_SITE_KIND;
typedef enum COREWEBVIEW2_HOST_RESOURCE_ACCESS_KIND
{
    COREWEBVIEW2_HOST_RESOURCE_ACCESS_KIND_DENY = 0,
    COREWEBVIEW2_HOST_RESOURCE_ACCESS_KIND_ALLOW = (COREWEBVIEW2_HOST_RESOURCE_ACCESS_KIND_DENY + 1),
    COREWEBVIEW2_HOST_RESOURCE_ACCESS_KIND_DENY_CORS = (COREWEBVIEW2_HOST_RESOURCE_ACCESS_KIND_ALLOW + 1)
} COREWEBVIEW2_HOST_RESOURCE_ACCESS_KIND;
typedef enum COREWEBVIEW2_SCRIPT_DIALOG_KIND
{
    COREWEBVIEW2_SCRIPT_DIALOG_KIND_ALERT = 0,
    COREWEBVIEW2_SCRIPT_DIALOG_KIND_CONFIRM = (COREWEBVIEW2_SCRIPT_DIALOG_KIND_ALERT + 1),
    COREWEBVIEW2_SCRIPT_DIALOG_KIND_PROMPT = (COREWEBVIEW2_SCRIPT_DIALOG_KIND_CONFIRM + 1),
    COREWEBVIEW2_SCRIPT_DIALOG_KIND_BEFOREUNLOAD = (COREWEBVIEW2_SCRIPT_DIALOG_KIND_PROMPT + 1)
} COREWEBVIEW2_SCRIPT_DIALOG_KIND;
typedef enum COREWEBVIEW2_PROCESS_FAILED_KIND
{
    COREWEBVIEW2_PROCESS_FAILED_KIND_BROWSER_PROCESS_EXITED = 0,
    COREWEBVIEW2_PROCESS_FAILED_KIND_RENDER_PROCESS_EXITED = (COREWEBVIEW2_PROCESS_FAILED_KIND_BROWSER_PROCESS_EXITED + 1),
    COREWEBVIEW2_PROCESS_FAILED_KIND_RENDER_PROCESS_UNRESPONSIVE = (COREWEBVIEW2_PROCESS_FAILED_KIND_RENDER_PROCESS_EXITED + 1)
} COREWEBVIEW2_PROCESS_FAILED_KIND;
typedef enum COREWEBVIEW2_PERMISSION_KIND
{
    COREWEBVIEW2_PERMISSION_KIND_UNKNOWN_PERMISSION = 0,
    COREWEBVIEW2_PERMISSION_KIND_MICROPHONE = (COREWEBVIEW2_PERMISSION_KIND_UNKNOWN_PERMISSION + 1),
    COREWEBVIEW2_PERMISSION_KIND_CAMERA = (COREWEBVIEW2_PERMISSION_KIND_MICROPHONE + 1),
    COREWEBVIEW2_PERMISSION_KIND_GEOLOCATION = (COREWEBVIEW2_PERMISSION_KIND_CAMERA + 1),
    COREWEBVIEW2_PERMISSION_KIND_NOTIFICATIONS = (COREWEBVIEW2_PERMISSION_KIND_GEOLOCATION + 1),
    COREWEBVIEW2_PERMISSION_KIND_OTHER_SENSORS = (COREWEBVIEW2_PERMISSION_KIND_NOTIFICATIONS + 1),
    COREWEBVIEW2_PERMISSION_KIND_CLIPBOARD_READ = (COREWEBVIEW2_PERMISSION_KIND_OTHER_SENSORS + 1)
} COREWEBVIEW2_PERMISSION_KIND;
typedef enum COREWEBVIEW2_PERMISSION_STATE
{
    COREWEBVIEW2_PERMISSION_STATE_DEFAULT = 0,
    COREWEBVIEW2_PERMISSION_STATE_ALLOW = (COREWEBVIEW2_PERMISSION_STATE_DEFAULT + 1),
    COREWEBVIEW2_PERMISSION_STATE_DENY = (COREWEBVIEW2_PERMISSION_STATE_ALLOW + 1)
} COREWEBVIEW2_PERMISSION_STATE;
typedef enum COREWEBVIEW2_WEB_ERROR_STATUS
{
    COREWEBVIEW2_WEB_ERROR_STATUS_UNKNOWN = 0,
    COREWEBVIEW2_WEB_ERROR_STATUS_CERTIFICATE_COMMON_NAME_IS_INCORRECT = (COREWEBVIEW2_WEB_ERROR_STATUS_UNKNOWN + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_CERTIFICATE_EXPIRED = (COREWEBVIEW2_WEB_ERROR_STATUS_CERTIFICATE_COMMON_NAME_IS_INCORRECT + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_CLIENT_CERTIFICATE_CONTAINS_ERRORS = (COREWEBVIEW2_WEB_ERROR_STATUS_CERTIFICATE_EXPIRED + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_CERTIFICATE_REVOKED = (COREWEBVIEW2_WEB_ERROR_STATUS_CLIENT_CERTIFICATE_CONTAINS_ERRORS + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_CERTIFICATE_IS_INVALID = (COREWEBVIEW2_WEB_ERROR_STATUS_CERTIFICATE_REVOKED + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_SERVER_UNREACHABLE = (COREWEBVIEW2_WEB_ERROR_STATUS_CERTIFICATE_IS_INVALID + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_TIMEOUT = (COREWEBVIEW2_WEB_ERROR_STATUS_SERVER_UNREACHABLE + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_ERROR_HTTP_INVALID_SERVER_RESPONSE = (COREWEBVIEW2_WEB_ERROR_STATUS_TIMEOUT + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_CONNECTION_ABORTED = (COREWEBVIEW2_WEB_ERROR_STATUS_ERROR_HTTP_INVALID_SERVER_RESPONSE + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_CONNECTION_RESET = (COREWEBVIEW2_WEB_ERROR_STATUS_CONNECTION_ABORTED + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_DISCONNECTED = (COREWEBVIEW2_WEB_ERROR_STATUS_CONNECTION_RESET + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_CANNOT_CONNECT = (COREWEBVIEW2_WEB_ERROR_STATUS_DISCONNECTED + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_HOST_NAME_NOT_RESOLVED = (COREWEBVIEW2_WEB_ERROR_STATUS_CANNOT_CONNECT + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_OPERATION_CANCELED = (COREWEBVIEW2_WEB_ERROR_STATUS_HOST_NAME_NOT_RESOLVED + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_REDIRECT_FAILED = (COREWEBVIEW2_WEB_ERROR_STATUS_OPERATION_CANCELED + 1),
    COREWEBVIEW2_WEB_ERROR_STATUS_UNEXPECTED_ERROR = (COREWEBVIEW2_WEB_ERROR_STATUS_REDIRECT_FAILED + 1)
} COREWEBVIEW2_WEB_ERROR_STATUS;
typedef enum COREWEBVIEW2_WEB_RESOURCE_CONTEXT
{
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_ALL = 0,
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_DOCUMENT = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_ALL + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_STYLESHEET = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_DOCUMENT + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_IMAGE = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_STYLESHEET + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_MEDIA = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_IMAGE + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_FONT = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_MEDIA + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_SCRIPT = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_FONT + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_XML_HTTP_REQUEST = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_SCRIPT + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_FETCH = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_XML_HTTP_REQUEST + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_TEXT_TRACK = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_FETCH + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_EVENT_SOURCE = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_TEXT_TRACK + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_WEBSOCKET = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_EVENT_SOURCE + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_MANIFEST = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_WEBSOCKET + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_SIGNED_EXCHANGE = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_MANIFEST + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_PING = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_SIGNED_EXCHANGE + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_CSP_VIOLATION_REPORT = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_PING + 1),
    COREWEBVIEW2_WEB_RESOURCE_CONTEXT_OTHER = (COREWEBVIEW2_WEB_RESOURCE_CONTEXT_CSP_VIOLATION_REPORT + 1)
} COREWEBVIEW2_WEB_RESOURCE_CONTEXT;
typedef enum COREWEBVIEW2_MOVE_FOCUS_REASON
{
    COREWEBVIEW2_MOVE_FOCUS_REASON_PROGRAMMATIC = 0,
    COREWEBVIEW2_MOVE_FOCUS_REASON_NEXT = (COREWEBVIEW2_MOVE_FOCUS_REASON_PROGRAMMATIC + 1),
    COREWEBVIEW2_MOVE_FOCUS_REASON_PREVIOUS = (COREWEBVIEW2_MOVE_FOCUS_REASON_NEXT + 1)
} COREWEBVIEW2_MOVE_FOCUS_REASON;
typedef enum COREWEBVIEW2_KEY_EVENT_KIND
{
    COREWEBVIEW2_KEY_EVENT_KIND_KEY_DOWN = 0,
    COREWEBVIEW2_KEY_EVENT_KIND_KEY_UP = (COREWEBVIEW2_KEY_EVENT_KIND_KEY_DOWN + 1),
    COREWEBVIEW2_KEY_EVENT_KIND_SYSTEM_KEY_DOWN = (COREWEBVIEW2_KEY_EVENT_KIND_KEY_UP + 1),
    COREWEBVIEW2_KEY_EVENT_KIND_SYSTEM_KEY_UP = (COREWEBVIEW2_KEY_EVENT_KIND_SYSTEM_KEY_DOWN + 1)
} COREWEBVIEW2_KEY_EVENT_KIND;
typedef struct COREWEBVIEW2_PHYSICAL_KEY_STATUS
{
    UINT32 RepeatCount;
    UINT32 ScanCode;
    BOOL IsExtendedKey;
    BOOL IsMenuKeyDown;
    BOOL WasKeyDown;
    BOOL IsKeyReleased;
} COREWEBVIEW2_PHYSICAL_KEY_STATUS;
typedef struct COREWEBVIEW2_COLOR
{
    BYTE A;
    BYTE R;
    BYTE G;
    BYTE B;
} COREWEBVIEW2_COLOR;
typedef enum COREWEBVIEW2_MOUSE_EVENT_KIND
{
    COREWEBVIEW2_MOUSE_EVENT_KIND_HORIZONTAL_WHEEL = 0x20e,
    COREWEBVIEW2_MOUSE_EVENT_KIND_LEFT_BUTTON_DOUBLE_CLICK = 0x203,
    COREWEBVIEW2_MOUSE_EVENT_KIND_LEFT_BUTTON_DOWN = 0x201,
    COREWEBVIEW2_MOUSE_EVENT_KIND_LEFT_BUTTON_UP = 0x202,
    COREWEBVIEW2_MOUSE_EVENT_KIND_LEAVE = 0x2a3,
    COREWEBVIEW2_MOUSE_EVENT_KIND_MIDDLE_BUTTON_DOUBLE_CLICK = 0x209,
    COREWEBVIEW2_MOUSE_EVENT_KIND_MIDDLE_BUTTON_DOWN = 0x207,
    COREWEBVIEW2_MOUSE_EVENT_KIND_MIDDLE_BUTTON_UP = 0x208,
    COREWEBVIEW2_MOUSE_EVENT_KIND_MOVE = 0x200,
    COREWEBVIEW2_MOUSE_EVENT_KIND_RIGHT_BUTTON_DOUBLE_CLICK = 0x206,
    COREWEBVIEW2_MOUSE_EVENT_KIND_RIGHT_BUTTON_DOWN = 0x204,
    COREWEBVIEW2_MOUSE_EVENT_KIND_RIGHT_BUTTON_UP = 0x205,
    COREWEBVIEW2_MOUSE_EVENT_KIND_WHEEL = 0x20a,
    COREWEBVIEW2_MOUSE_EVENT_KIND_X_BUTTON_DOUBLE_CLICK = 0x20d,
    COREWEBVIEW2_MOUSE_EVENT_KIND_X_BUTTON_DOWN = 0x20b,
    COREWEBVIEW2_MOUSE_EVENT_KIND_X_BUTTON_UP = 0x20c
} COREWEBVIEW2_MOUSE_EVENT_KIND;
typedef enum COREWEBVIEW2_MOUSE_EVENT_VIRTUAL_KEYS
{
    COREWEBVIEW2_MOUSE_EVENT_VIRTUAL_KEYS_NONE = 0,
    COREWEBVIEW2_MOUSE_EVENT_VIRTUAL_KEYS_LEFT_BUTTON = 0x1,
    COREWEBVIEW2_MOUSE_EVENT_VIRTUAL_KEYS_RIGHT_BUTTON = 0x2,
    COREWEBVIEW2_MOUSE_EVENT_VIRTUAL_KEYS_SHIFT = 0x4,
    COREWEBVIEW2_MOUSE_EVENT_VIRTUAL_KEYS_CONTROL = 0x8,
    COREWEBVIEW2_MOUSE_EVENT_VIRTUAL_KEYS_MIDDLE_BUTTON = 0x10,
    COREWEBVIEW2_MOUSE_EVENT_VIRTUAL_KEYS_X_BUTTON1 = 0x20,
    COREWEBVIEW2_MOUSE_EVENT_VIRTUAL_KEYS_X_BUTTON2 = 0x40
} COREWEBVIEW2_MOUSE_EVENT_VIRTUAL_KEYS;
typedef enum COREWEBVIEW2_POINTER_EVENT_KIND
{
    COREWEBVIEW2_POINTER_EVENT_KIND_ACTIVATE = 0x24b,
    COREWEBVIEW2_POINTER_EVENT_KIND_DOWN = 0x246,
    COREWEBVIEW2_POINTER_EVENT_KIND_ENTER = 0x249,
    COREWEBVIEW2_POINTER_EVENT_KIND_LEAVE = 0x24a,
    COREWEBVIEW2_POINTER_EVENT_KIND_UP = 0x247,
    COREWEBVIEW2_POINTER_EVENT_KIND_UPDATE = 0x245
} COREWEBVIEW2_POINTER_EVENT_KIND;
typedef enum COREWEBVIEW2_BOUNDS_MODE
{
    COREWEBVIEW2_BOUNDS_MODE_USE_RAW_PIXELS = 0,
    COREWEBVIEW2_BOUNDS_MODE_USE_RASTERIZATION_SCALE = (COREWEBVIEW2_BOUNDS_MODE_USE_RAW_PIXELS + 1)
} COREWEBVIEW2_BOUNDS_MODE;
extern HRESULT CreateCoreWebView2EnvironmentWithOptions(PCWSTR browserExecutableFolder, PCWSTR userDataFolder, ICoreWebView2EnvironmentOptions* environmentOptions, ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler* environmentCreatedHandler);
extern HRESULT CreateCoreWebView2Environment(ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler* environmentCreatedHandler);
extern HRESULT GetAvailableCoreWebView2BrowserVersionString(PCWSTR browserExecutableFolder, LPWSTR* versionInfo);
extern HRESULT CompareBrowserVersions(PCWSTR version1, PCWSTR version2, int* result);
typedef struct ICoreWebView2AcceleratorKeyPressedEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2AcceleratorKeyPressedEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2AcceleratorKeyPressedEventArgs* This);
    ULONG (*Release)(ICoreWebView2AcceleratorKeyPressedEventArgs* This);
    HRESULT (*get_KeyEventKind)(ICoreWebView2AcceleratorKeyPressedEventArgs* This, COREWEBVIEW2_KEY_EVENT_KIND* keyEventKind);
    HRESULT (*get_VirtualKey)(ICoreWebView2AcceleratorKeyPressedEventArgs* This, UINT* virtualKey);
    HRESULT (*get_KeyEventLParam)(ICoreWebView2AcceleratorKeyPressedEventArgs* This, INT* lParam);
    HRESULT (*get_PhysicalKeyStatus)(ICoreWebView2AcceleratorKeyPressedEventArgs* This, COREWEBVIEW2_PHYSICAL_KEY_STATUS* physicalKeyStatus);
    HRESULT (*get_Handled)(ICoreWebView2AcceleratorKeyPressedEventArgs* This, BOOL* handled);
    HRESULT (*put_Handled)(ICoreWebView2AcceleratorKeyPressedEventArgs* This, BOOL handled);
} ICoreWebView2AcceleratorKeyPressedEventArgsVtbl;
struct ICoreWebView2AcceleratorKeyPressedEventArgs
{
    struct ICoreWebView2AcceleratorKeyPressedEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2AcceleratorKeyPressedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2AcceleratorKeyPressedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2AcceleratorKeyPressedEventHandler* This);
    ULONG (*Release)(ICoreWebView2AcceleratorKeyPressedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2AcceleratorKeyPressedEventHandler* This, ICoreWebView2Controller* sender, ICoreWebView2AcceleratorKeyPressedEventArgs* args);
} ICoreWebView2AcceleratorKeyPressedEventHandlerVtbl;
struct ICoreWebView2AcceleratorKeyPressedEventHandler
{
    struct ICoreWebView2AcceleratorKeyPressedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler* This);
    ULONG (*Release)(ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler* This);
    HRESULT (*Invoke)(ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler* This, HRESULT errorCode, LPCWSTR id);
} ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandlerVtbl;
struct ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler
{
    struct ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2CallDevToolsProtocolMethodCompletedHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2CallDevToolsProtocolMethodCompletedHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2CallDevToolsProtocolMethodCompletedHandler* This);
    ULONG (*Release)(ICoreWebView2CallDevToolsProtocolMethodCompletedHandler* This);
    HRESULT (*Invoke)(ICoreWebView2CallDevToolsProtocolMethodCompletedHandler* This, HRESULT errorCode, LPCWSTR returnObjectAsJson);
} ICoreWebView2CallDevToolsProtocolMethodCompletedHandlerVtbl;
struct ICoreWebView2CallDevToolsProtocolMethodCompletedHandler
{
    struct ICoreWebView2CallDevToolsProtocolMethodCompletedHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2CapturePreviewCompletedHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2CapturePreviewCompletedHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2CapturePreviewCompletedHandler* This);
    ULONG (*Release)(ICoreWebView2CapturePreviewCompletedHandler* This);
    HRESULT (*Invoke)(ICoreWebView2CapturePreviewCompletedHandler* This, HRESULT errorCode);
} ICoreWebView2CapturePreviewCompletedHandlerVtbl;
struct ICoreWebView2CapturePreviewCompletedHandler
{
    struct ICoreWebView2CapturePreviewCompletedHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2Vtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2* This);
    ULONG (*Release)(ICoreWebView2* This);
    HRESULT (*get_Settings)(ICoreWebView2* This, ICoreWebView2Settings** settings);
    HRESULT (*get_Source)(ICoreWebView2* This, LPWSTR* uri);
    HRESULT (*Navigate)(ICoreWebView2* This, LPCWSTR uri);
    HRESULT (*NavigateToString)(ICoreWebView2* This, LPCWSTR htmlContent);
    HRESULT (*add_NavigationStarting)(ICoreWebView2* This, ICoreWebView2NavigationStartingEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_NavigationStarting)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*add_ContentLoading)(ICoreWebView2* This, ICoreWebView2ContentLoadingEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ContentLoading)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*add_SourceChanged)(ICoreWebView2* This, ICoreWebView2SourceChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_SourceChanged)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*add_HistoryChanged)(ICoreWebView2* This, ICoreWebView2HistoryChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_HistoryChanged)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*add_NavigationCompleted)(ICoreWebView2* This, ICoreWebView2NavigationCompletedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_NavigationCompleted)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*add_FrameNavigationStarting)(ICoreWebView2* This, ICoreWebView2NavigationStartingEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_FrameNavigationStarting)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*add_FrameNavigationCompleted)(ICoreWebView2* This, ICoreWebView2NavigationCompletedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_FrameNavigationCompleted)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*add_ScriptDialogOpening)(ICoreWebView2* This, ICoreWebView2ScriptDialogOpeningEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ScriptDialogOpening)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*add_PermissionRequested)(ICoreWebView2* This, ICoreWebView2PermissionRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_PermissionRequested)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*add_ProcessFailed)(ICoreWebView2* This, ICoreWebView2ProcessFailedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ProcessFailed)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*AddScriptToExecuteOnDocumentCreated)(ICoreWebView2* This, LPCWSTR javaScript, ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler* handler);
    HRESULT (*RemoveScriptToExecuteOnDocumentCreated)(ICoreWebView2* This, LPCWSTR id);
    HRESULT (*ExecuteScript)(ICoreWebView2* This, LPCWSTR javaScript, ICoreWebView2ExecuteScriptCompletedHandler* handler);
    HRESULT (*CapturePreview)(ICoreWebView2* This, COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT imageFormat, IStream* imageStream, ICoreWebView2CapturePreviewCompletedHandler* handler);
    HRESULT (*Reload)(ICoreWebView2* This);
    HRESULT (*PostWebMessageAsJson)(ICoreWebView2* This, LPCWSTR webMessageAsJson);
    HRESULT (*PostWebMessageAsString)(ICoreWebView2* This, LPCWSTR webMessageAsString);
    HRESULT (*add_WebMessageReceived)(ICoreWebView2* This, ICoreWebView2WebMessageReceivedEventHandler* handler, EventRegistrationToken* token);
    HRESULT (*remove_WebMessageReceived)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*CallDevToolsProtocolMethod)(ICoreWebView2* This, LPCWSTR methodName, LPCWSTR parametersAsJson, ICoreWebView2CallDevToolsProtocolMethodCompletedHandler* handler);
    HRESULT (*get_BrowserProcessId)(ICoreWebView2* This, UINT32* value);
    HRESULT (*get_CanGoBack)(ICoreWebView2* This, BOOL* canGoBack);
    HRESULT (*get_CanGoForward)(ICoreWebView2* This, BOOL* canGoForward);
    HRESULT (*GoBack)(ICoreWebView2* This);
    HRESULT (*GoForward)(ICoreWebView2* This);
    HRESULT (*GetDevToolsProtocolEventReceiver)(ICoreWebView2* This, LPCWSTR eventName, ICoreWebView2DevToolsProtocolEventReceiver** receiver);
    HRESULT (*Stop)(ICoreWebView2* This);
    HRESULT (*add_NewWindowRequested)(ICoreWebView2* This, ICoreWebView2NewWindowRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_NewWindowRequested)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*add_DocumentTitleChanged)(ICoreWebView2* This, ICoreWebView2DocumentTitleChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_DocumentTitleChanged)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*get_DocumentTitle)(ICoreWebView2* This, LPWSTR* title);
    HRESULT (*AddHostObjectToScript)(ICoreWebView2* This, LPCWSTR name, VARIANT* object);
    HRESULT (*RemoveHostObjectFromScript)(ICoreWebView2* This, LPCWSTR name);
    HRESULT (*OpenDevToolsWindow)(ICoreWebView2* This);
    HRESULT (*add_ContainsFullScreenElementChanged)(ICoreWebView2* This, ICoreWebView2ContainsFullScreenElementChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ContainsFullScreenElementChanged)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*get_ContainsFullScreenElement)(ICoreWebView2* This, BOOL* containsFullScreenElement);
    HRESULT (*add_WebResourceRequested)(ICoreWebView2* This, ICoreWebView2WebResourceRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_WebResourceRequested)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT (*AddWebResourceRequestedFilter)(ICoreWebView2* This, const LPCWSTR uri, const COREWEBVIEW2_WEB_RESOURCE_CONTEXT resourceContext);
    HRESULT (*RemoveWebResourceRequestedFilter)(ICoreWebView2* This, const LPCWSTR uri, const COREWEBVIEW2_WEB_RESOURCE_CONTEXT resourceContext);
    HRESULT (*add_WindowCloseRequested)(ICoreWebView2* This, ICoreWebView2WindowCloseRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_WindowCloseRequested)(ICoreWebView2* This, EventRegistrationToken token);
} ICoreWebView2Vtbl;
struct ICoreWebView2
{
    struct ICoreWebView2Vtbl* lpVtbl;
};
typedef struct ICoreWebView2_2Vtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2_2* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2_2* This);
    ULONG (*Release)(ICoreWebView2_2* This);
    HRESULT (*get_Settings)(ICoreWebView2_2* This, ICoreWebView2Settings** settings);
    HRESULT (*get_Source)(ICoreWebView2_2* This, LPWSTR* uri);
    HRESULT (*Navigate)(ICoreWebView2_2* This, LPCWSTR uri);
    HRESULT (*NavigateToString)(ICoreWebView2_2* This, LPCWSTR htmlContent);
    HRESULT (*add_NavigationStarting)(ICoreWebView2_2* This, ICoreWebView2NavigationStartingEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_NavigationStarting)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*add_ContentLoading)(ICoreWebView2_2* This, ICoreWebView2ContentLoadingEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ContentLoading)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*add_SourceChanged)(ICoreWebView2_2* This, ICoreWebView2SourceChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_SourceChanged)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*add_HistoryChanged)(ICoreWebView2_2* This, ICoreWebView2HistoryChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_HistoryChanged)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*add_NavigationCompleted)(ICoreWebView2_2* This, ICoreWebView2NavigationCompletedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_NavigationCompleted)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*add_FrameNavigationStarting)(ICoreWebView2_2* This, ICoreWebView2NavigationStartingEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_FrameNavigationStarting)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*add_FrameNavigationCompleted)(ICoreWebView2_2* This, ICoreWebView2NavigationCompletedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_FrameNavigationCompleted)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*add_ScriptDialogOpening)(ICoreWebView2_2* This, ICoreWebView2ScriptDialogOpeningEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ScriptDialogOpening)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*add_PermissionRequested)(ICoreWebView2_2* This, ICoreWebView2PermissionRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_PermissionRequested)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*add_ProcessFailed)(ICoreWebView2_2* This, ICoreWebView2ProcessFailedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ProcessFailed)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*AddScriptToExecuteOnDocumentCreated)(ICoreWebView2_2* This, LPCWSTR javaScript, ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler* handler);
    HRESULT (*RemoveScriptToExecuteOnDocumentCreated)(ICoreWebView2_2* This, LPCWSTR id);
    HRESULT (*ExecuteScript)(ICoreWebView2_2* This, LPCWSTR javaScript, ICoreWebView2ExecuteScriptCompletedHandler* handler);
    HRESULT (*CapturePreview)(ICoreWebView2_2* This, COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT imageFormat, IStream* imageStream, ICoreWebView2CapturePreviewCompletedHandler* handler);
    HRESULT (*Reload)(ICoreWebView2_2* This);
    HRESULT (*PostWebMessageAsJson)(ICoreWebView2_2* This, LPCWSTR webMessageAsJson);
    HRESULT (*PostWebMessageAsString)(ICoreWebView2_2* This, LPCWSTR webMessageAsString);
    HRESULT (*add_WebMessageReceived)(ICoreWebView2_2* This, ICoreWebView2WebMessageReceivedEventHandler* handler, EventRegistrationToken* token);
    HRESULT (*remove_WebMessageReceived)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*CallDevToolsProtocolMethod)(ICoreWebView2_2* This, LPCWSTR methodName, LPCWSTR parametersAsJson, ICoreWebView2CallDevToolsProtocolMethodCompletedHandler* handler);
    HRESULT (*get_BrowserProcessId)(ICoreWebView2_2* This, UINT32* value);
    HRESULT (*get_CanGoBack)(ICoreWebView2_2* This, BOOL* canGoBack);
    HRESULT (*get_CanGoForward)(ICoreWebView2_2* This, BOOL* canGoForward);
    HRESULT (*GoBack)(ICoreWebView2_2* This);
    HRESULT (*GoForward)(ICoreWebView2_2* This);
    HRESULT (*GetDevToolsProtocolEventReceiver)(ICoreWebView2_2* This, LPCWSTR eventName, ICoreWebView2DevToolsProtocolEventReceiver** receiver);
    HRESULT (*Stop)(ICoreWebView2_2* This);
    HRESULT (*add_NewWindowRequested)(ICoreWebView2_2* This, ICoreWebView2NewWindowRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_NewWindowRequested)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*add_DocumentTitleChanged)(ICoreWebView2_2* This, ICoreWebView2DocumentTitleChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_DocumentTitleChanged)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*get_DocumentTitle)(ICoreWebView2_2* This, LPWSTR* title);
    HRESULT (*AddHostObjectToScript)(ICoreWebView2_2* This, LPCWSTR name, VARIANT* object);
    HRESULT (*RemoveHostObjectFromScript)(ICoreWebView2_2* This, LPCWSTR name);
    HRESULT (*OpenDevToolsWindow)(ICoreWebView2_2* This);
    HRESULT (*add_ContainsFullScreenElementChanged)(ICoreWebView2_2* This, ICoreWebView2ContainsFullScreenElementChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ContainsFullScreenElementChanged)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*get_ContainsFullScreenElement)(ICoreWebView2_2* This, BOOL* containsFullScreenElement);
    HRESULT (*add_WebResourceRequested)(ICoreWebView2_2* This, ICoreWebView2WebResourceRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_WebResourceRequested)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*AddWebResourceRequestedFilter)(ICoreWebView2_2* This, const LPCWSTR uri, const COREWEBVIEW2_WEB_RESOURCE_CONTEXT resourceContext);
    HRESULT (*RemoveWebResourceRequestedFilter)(ICoreWebView2_2* This, const LPCWSTR uri, const COREWEBVIEW2_WEB_RESOURCE_CONTEXT resourceContext);
    HRESULT (*add_WindowCloseRequested)(ICoreWebView2_2* This, ICoreWebView2WindowCloseRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_WindowCloseRequested)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*add_WebResourceResponseReceived)(ICoreWebView2_2* This, ICoreWebView2WebResourceResponseReceivedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_WebResourceResponseReceived)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*NavigateWithWebResourceRequest)(ICoreWebView2_2* This, ICoreWebView2WebResourceRequest* request);
    HRESULT (*add_DOMContentLoaded)(ICoreWebView2_2* This, ICoreWebView2DOMContentLoadedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_DOMContentLoaded)(ICoreWebView2_2* This, EventRegistrationToken token);
    HRESULT (*get_CookieManager)(ICoreWebView2_2* This, ICoreWebView2CookieManager** cookieManager);
    HRESULT (*get_Environment)(ICoreWebView2_2* This, ICoreWebView2Environment** environment);
} ICoreWebView2_2Vtbl;
struct ICoreWebView2_2
{
    struct ICoreWebView2_2Vtbl* lpVtbl;
};
typedef struct ICoreWebView2_3Vtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2_3* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2_3* This);
    ULONG (*Release)(ICoreWebView2_3* This);
    HRESULT (*get_Settings)(ICoreWebView2_3* This, ICoreWebView2Settings** settings);
    HRESULT (*get_Source)(ICoreWebView2_3* This, LPWSTR* uri);
    HRESULT (*Navigate)(ICoreWebView2_3* This, LPCWSTR uri);
    HRESULT (*NavigateToString)(ICoreWebView2_3* This, LPCWSTR htmlContent);
    HRESULT (*add_NavigationStarting)(ICoreWebView2_3* This, ICoreWebView2NavigationStartingEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_NavigationStarting)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*add_ContentLoading)(ICoreWebView2_3* This, ICoreWebView2ContentLoadingEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ContentLoading)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*add_SourceChanged)(ICoreWebView2_3* This, ICoreWebView2SourceChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_SourceChanged)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*add_HistoryChanged)(ICoreWebView2_3* This, ICoreWebView2HistoryChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_HistoryChanged)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*add_NavigationCompleted)(ICoreWebView2_3* This, ICoreWebView2NavigationCompletedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_NavigationCompleted)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*add_FrameNavigationStarting)(ICoreWebView2_3* This, ICoreWebView2NavigationStartingEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_FrameNavigationStarting)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*add_FrameNavigationCompleted)(ICoreWebView2_3* This, ICoreWebView2NavigationCompletedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_FrameNavigationCompleted)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*add_ScriptDialogOpening)(ICoreWebView2_3* This, ICoreWebView2ScriptDialogOpeningEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ScriptDialogOpening)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*add_PermissionRequested)(ICoreWebView2_3* This, ICoreWebView2PermissionRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_PermissionRequested)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*add_ProcessFailed)(ICoreWebView2_3* This, ICoreWebView2ProcessFailedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ProcessFailed)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*AddScriptToExecuteOnDocumentCreated)(ICoreWebView2_3* This, LPCWSTR javaScript, ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler* handler);
    HRESULT (*RemoveScriptToExecuteOnDocumentCreated)(ICoreWebView2_3* This, LPCWSTR id);
    HRESULT (*ExecuteScript)(ICoreWebView2_3* This, LPCWSTR javaScript, ICoreWebView2ExecuteScriptCompletedHandler* handler);
    HRESULT (*CapturePreview)(ICoreWebView2_3* This, COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT imageFormat, IStream* imageStream, ICoreWebView2CapturePreviewCompletedHandler* handler);
    HRESULT (*Reload)(ICoreWebView2_3* This);
    HRESULT (*PostWebMessageAsJson)(ICoreWebView2_3* This, LPCWSTR webMessageAsJson);
    HRESULT (*PostWebMessageAsString)(ICoreWebView2_3* This, LPCWSTR webMessageAsString);
    HRESULT (*add_WebMessageReceived)(ICoreWebView2_3* This, ICoreWebView2WebMessageReceivedEventHandler* handler, EventRegistrationToken* token);
    HRESULT (*remove_WebMessageReceived)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*CallDevToolsProtocolMethod)(ICoreWebView2_3* This, LPCWSTR methodName, LPCWSTR parametersAsJson, ICoreWebView2CallDevToolsProtocolMethodCompletedHandler* handler);
    HRESULT (*get_BrowserProcessId)(ICoreWebView2_3* This, UINT32* value);
    HRESULT (*get_CanGoBack)(ICoreWebView2_3* This, BOOL* canGoBack);
    HRESULT (*get_CanGoForward)(ICoreWebView2_3* This, BOOL* canGoForward);
    HRESULT (*GoBack)(ICoreWebView2_3* This);
    HRESULT (*GoForward)(ICoreWebView2_3* This);
    HRESULT (*GetDevToolsProtocolEventReceiver)(ICoreWebView2_3* This, LPCWSTR eventName, ICoreWebView2DevToolsProtocolEventReceiver** receiver);
    HRESULT (*Stop)(ICoreWebView2_3* This);
    HRESULT (*add_NewWindowRequested)(ICoreWebView2_3* This, ICoreWebView2NewWindowRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_NewWindowRequested)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*add_DocumentTitleChanged)(ICoreWebView2_3* This, ICoreWebView2DocumentTitleChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_DocumentTitleChanged)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*get_DocumentTitle)(ICoreWebView2_3* This, LPWSTR* title);
    HRESULT (*AddHostObjectToScript)(ICoreWebView2_3* This, LPCWSTR name, VARIANT* object);
    HRESULT (*RemoveHostObjectFromScript)(ICoreWebView2_3* This, LPCWSTR name);
    HRESULT (*OpenDevToolsWindow)(ICoreWebView2_3* This);
    HRESULT (*add_ContainsFullScreenElementChanged)(ICoreWebView2_3* This, ICoreWebView2ContainsFullScreenElementChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ContainsFullScreenElementChanged)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*get_ContainsFullScreenElement)(ICoreWebView2_3* This, BOOL* containsFullScreenElement);
    HRESULT (*add_WebResourceRequested)(ICoreWebView2_3* This, ICoreWebView2WebResourceRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_WebResourceRequested)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*AddWebResourceRequestedFilter)(ICoreWebView2_3* This, const LPCWSTR uri, const COREWEBVIEW2_WEB_RESOURCE_CONTEXT resourceContext);
    HRESULT (*RemoveWebResourceRequestedFilter)(ICoreWebView2_3* This, const LPCWSTR uri, const COREWEBVIEW2_WEB_RESOURCE_CONTEXT resourceContext);
    HRESULT (*add_WindowCloseRequested)(ICoreWebView2_3* This, ICoreWebView2WindowCloseRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_WindowCloseRequested)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*add_WebResourceResponseReceived)(ICoreWebView2_3* This, ICoreWebView2WebResourceResponseReceivedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_WebResourceResponseReceived)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*NavigateWithWebResourceRequest)(ICoreWebView2_3* This, ICoreWebView2WebResourceRequest* request);
    HRESULT (*add_DOMContentLoaded)(ICoreWebView2_3* This, ICoreWebView2DOMContentLoadedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_DOMContentLoaded)(ICoreWebView2_3* This, EventRegistrationToken token);
    HRESULT (*get_CookieManager)(ICoreWebView2_3* This, ICoreWebView2CookieManager** cookieManager);
    HRESULT (*get_Environment)(ICoreWebView2_3* This, ICoreWebView2Environment** environment);
    HRESULT (*TrySuspend)(ICoreWebView2_3* This, ICoreWebView2TrySuspendCompletedHandler* handler);
    HRESULT (*Resume)(ICoreWebView2_3* This);
    HRESULT (*get_IsSuspended)(ICoreWebView2_3* This, BOOL* isSuspended);
    HRESULT (*SetVirtualHostNameToFolderMapping)(ICoreWebView2_3* This, LPCWSTR hostName, LPCWSTR folderPath, COREWEBVIEW2_HOST_RESOURCE_ACCESS_KIND accessKind);
    HRESULT (*ClearVirtualHostNameToFolderMapping)(ICoreWebView2_3* This, LPCWSTR hostName);
} ICoreWebView2_3Vtbl;
struct ICoreWebView2_3
{
    struct ICoreWebView2_3Vtbl* lpVtbl;
};
typedef struct ICoreWebView2CompositionControllerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2CompositionController* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2CompositionController* This);
    ULONG (*Release)(ICoreWebView2CompositionController* This);
    HRESULT (*get_RootVisualTarget)(ICoreWebView2CompositionController* This, IUnknown** target);
    HRESULT (*put_RootVisualTarget)(ICoreWebView2CompositionController* This, IUnknown* target);
    HRESULT (*SendMouseInput)(ICoreWebView2CompositionController* This, COREWEBVIEW2_MOUSE_EVENT_KIND eventKind, COREWEBVIEW2_MOUSE_EVENT_VIRTUAL_KEYS virtualKeys, UINT32 mouseData, POINT point);
    HRESULT (*SendPointerInput)(ICoreWebView2CompositionController* This, COREWEBVIEW2_POINTER_EVENT_KIND eventKind, ICoreWebView2PointerInfo* pointerInfo);
    HRESULT (*get_Cursor)(ICoreWebView2CompositionController* This, HCURSOR* cursor);
    HRESULT (*get_SystemCursorId)(ICoreWebView2CompositionController* This, UINT32* systemCursorId);
    HRESULT (*add_CursorChanged)(ICoreWebView2CompositionController* This, ICoreWebView2CursorChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_CursorChanged)(ICoreWebView2CompositionController* This, EventRegistrationToken token);
} ICoreWebView2CompositionControllerVtbl;
struct ICoreWebView2CompositionController
{
    struct ICoreWebView2CompositionControllerVtbl* lpVtbl;
};
typedef struct ICoreWebView2CompositionController2Vtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2CompositionController2* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2CompositionController2* This);
    ULONG (*Release)(ICoreWebView2CompositionController2* This);
    HRESULT (*get_RootVisualTarget)(ICoreWebView2CompositionController2* This, IUnknown** target);
    HRESULT (*put_RootVisualTarget)(ICoreWebView2CompositionController2* This, IUnknown* target);
    HRESULT (*SendMouseInput)(ICoreWebView2CompositionController2* This, COREWEBVIEW2_MOUSE_EVENT_KIND eventKind, COREWEBVIEW2_MOUSE_EVENT_VIRTUAL_KEYS virtualKeys, UINT32 mouseData, POINT point);
    HRESULT (*SendPointerInput)(ICoreWebView2CompositionController2* This, COREWEBVIEW2_POINTER_EVENT_KIND eventKind, ICoreWebView2PointerInfo* pointerInfo);
    HRESULT (*get_Cursor)(ICoreWebView2CompositionController2* This, HCURSOR* cursor);
    HRESULT (*get_SystemCursorId)(ICoreWebView2CompositionController2* This, UINT32* systemCursorId);
    HRESULT (*add_CursorChanged)(ICoreWebView2CompositionController2* This, ICoreWebView2CursorChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_CursorChanged)(ICoreWebView2CompositionController2* This, EventRegistrationToken token);
    HRESULT (*get_UIAProvider)(ICoreWebView2CompositionController2* This, IUnknown** provider);
} ICoreWebView2CompositionController2Vtbl;
struct ICoreWebView2CompositionController2
{
    struct ICoreWebView2CompositionController2Vtbl* lpVtbl;
};
typedef struct ICoreWebView2ControllerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2Controller* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2Controller* This);
    ULONG (*Release)(ICoreWebView2Controller* This);
    HRESULT (*get_IsVisible)(ICoreWebView2Controller* This, BOOL* isVisible);
    HRESULT (*put_IsVisible)(ICoreWebView2Controller* This, BOOL isVisible);
    HRESULT (*get_Bounds)(ICoreWebView2Controller* This, RECT* bounds);
    HRESULT (*put_Bounds)(ICoreWebView2Controller* This, RECT bounds);
    HRESULT (*get_ZoomFactor)(ICoreWebView2Controller* This, double* zoomFactor);
    HRESULT (*put_ZoomFactor)(ICoreWebView2Controller* This, double zoomFactor);
    HRESULT (*add_ZoomFactorChanged)(ICoreWebView2Controller* This, ICoreWebView2ZoomFactorChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ZoomFactorChanged)(ICoreWebView2Controller* This, EventRegistrationToken token);
    HRESULT (*SetBoundsAndZoomFactor)(ICoreWebView2Controller* This, RECT bounds, double zoomFactor);
    HRESULT (*MoveFocus)(ICoreWebView2Controller* This, COREWEBVIEW2_MOVE_FOCUS_REASON reason);
    HRESULT (*add_MoveFocusRequested)(ICoreWebView2Controller* This, ICoreWebView2MoveFocusRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_MoveFocusRequested)(ICoreWebView2Controller* This, EventRegistrationToken token);
    HRESULT (*add_GotFocus)(ICoreWebView2Controller* This, ICoreWebView2FocusChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_GotFocus)(ICoreWebView2Controller* This, EventRegistrationToken token);
    HRESULT (*add_LostFocus)(ICoreWebView2Controller* This, ICoreWebView2FocusChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_LostFocus)(ICoreWebView2Controller* This, EventRegistrationToken token);
    HRESULT (*add_AcceleratorKeyPressed)(ICoreWebView2Controller* This, ICoreWebView2AcceleratorKeyPressedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_AcceleratorKeyPressed)(ICoreWebView2Controller* This, EventRegistrationToken token);
    HRESULT (*get_ParentWindow)(ICoreWebView2Controller* This, HWND* parentWindow);
    HRESULT (*put_ParentWindow)(ICoreWebView2Controller* This, HWND parentWindow);
    HRESULT (*NotifyParentWindowPositionChanged)(ICoreWebView2Controller* This);
    HRESULT (*Close)(ICoreWebView2Controller* This);
    HRESULT (*get_CoreWebView2)(ICoreWebView2Controller* This, ICoreWebView2** coreWebView2);
} ICoreWebView2ControllerVtbl;
struct ICoreWebView2Controller
{
    struct ICoreWebView2ControllerVtbl* lpVtbl;
};
typedef struct ICoreWebView2Controller2Vtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2Controller2* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2Controller2* This);
    ULONG (*Release)(ICoreWebView2Controller2* This);
    HRESULT (*get_IsVisible)(ICoreWebView2Controller2* This, BOOL* isVisible);
    HRESULT (*put_IsVisible)(ICoreWebView2Controller2* This, BOOL isVisible);
    HRESULT (*get_Bounds)(ICoreWebView2Controller2* This, RECT* bounds);
    HRESULT (*put_Bounds)(ICoreWebView2Controller2* This, RECT bounds);
    HRESULT (*get_ZoomFactor)(ICoreWebView2Controller2* This, double* zoomFactor);
    HRESULT (*put_ZoomFactor)(ICoreWebView2Controller2* This, double zoomFactor);
    HRESULT (*add_ZoomFactorChanged)(ICoreWebView2Controller2* This, ICoreWebView2ZoomFactorChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ZoomFactorChanged)(ICoreWebView2Controller2* This, EventRegistrationToken token);
    HRESULT (*SetBoundsAndZoomFactor)(ICoreWebView2Controller2* This, RECT bounds, double zoomFactor);
    HRESULT (*MoveFocus)(ICoreWebView2Controller2* This, COREWEBVIEW2_MOVE_FOCUS_REASON reason);
    HRESULT (*add_MoveFocusRequested)(ICoreWebView2Controller2* This, ICoreWebView2MoveFocusRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_MoveFocusRequested)(ICoreWebView2Controller2* This, EventRegistrationToken token);
    HRESULT (*add_GotFocus)(ICoreWebView2Controller2* This, ICoreWebView2FocusChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_GotFocus)(ICoreWebView2Controller2* This, EventRegistrationToken token);
    HRESULT (*add_LostFocus)(ICoreWebView2Controller2* This, ICoreWebView2FocusChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_LostFocus)(ICoreWebView2Controller2* This, EventRegistrationToken token);
    HRESULT (*add_AcceleratorKeyPressed)(ICoreWebView2Controller2* This, ICoreWebView2AcceleratorKeyPressedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_AcceleratorKeyPressed)(ICoreWebView2Controller2* This, EventRegistrationToken token);
    HRESULT (*get_ParentWindow)(ICoreWebView2Controller2* This, HWND* parentWindow);
    HRESULT (*put_ParentWindow)(ICoreWebView2Controller2* This, HWND parentWindow);
    HRESULT (*NotifyParentWindowPositionChanged)(ICoreWebView2Controller2* This);
    HRESULT (*Close)(ICoreWebView2Controller2* This);
    HRESULT (*get_CoreWebView2)(ICoreWebView2Controller2* This, ICoreWebView2** coreWebView2);
    HRESULT (*get_DefaultBackgroundColor)(ICoreWebView2Controller2* This, COREWEBVIEW2_COLOR* backgroundColor);
    HRESULT (*put_DefaultBackgroundColor)(ICoreWebView2Controller2* This, COREWEBVIEW2_COLOR backgroundColor);
} ICoreWebView2Controller2Vtbl;
struct ICoreWebView2Controller2
{
    struct ICoreWebView2Controller2Vtbl* lpVtbl;
};
typedef struct ICoreWebView2Controller3Vtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2Controller3* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2Controller3* This);
    ULONG (*Release)(ICoreWebView2Controller3* This);
    HRESULT (*get_IsVisible)(ICoreWebView2Controller3* This, BOOL* isVisible);
    HRESULT (*put_IsVisible)(ICoreWebView2Controller3* This, BOOL isVisible);
    HRESULT (*get_Bounds)(ICoreWebView2Controller3* This, RECT* bounds);
    HRESULT (*put_Bounds)(ICoreWebView2Controller3* This, RECT bounds);
    HRESULT (*get_ZoomFactor)(ICoreWebView2Controller3* This, double* zoomFactor);
    HRESULT (*put_ZoomFactor)(ICoreWebView2Controller3* This, double zoomFactor);
    HRESULT (*add_ZoomFactorChanged)(ICoreWebView2Controller3* This, ICoreWebView2ZoomFactorChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_ZoomFactorChanged)(ICoreWebView2Controller3* This, EventRegistrationToken token);
    HRESULT (*SetBoundsAndZoomFactor)(ICoreWebView2Controller3* This, RECT bounds, double zoomFactor);
    HRESULT (*MoveFocus)(ICoreWebView2Controller3* This, COREWEBVIEW2_MOVE_FOCUS_REASON reason);
    HRESULT (*add_MoveFocusRequested)(ICoreWebView2Controller3* This, ICoreWebView2MoveFocusRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_MoveFocusRequested)(ICoreWebView2Controller3* This, EventRegistrationToken token);
    HRESULT (*add_GotFocus)(ICoreWebView2Controller3* This, ICoreWebView2FocusChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_GotFocus)(ICoreWebView2Controller3* This, EventRegistrationToken token);
    HRESULT (*add_LostFocus)(ICoreWebView2Controller3* This, ICoreWebView2FocusChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_LostFocus)(ICoreWebView2Controller3* This, EventRegistrationToken token);
    HRESULT (*add_AcceleratorKeyPressed)(ICoreWebView2Controller3* This, ICoreWebView2AcceleratorKeyPressedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_AcceleratorKeyPressed)(ICoreWebView2Controller3* This, EventRegistrationToken token);
    HRESULT (*get_ParentWindow)(ICoreWebView2Controller3* This, HWND* parentWindow);
    HRESULT (*put_ParentWindow)(ICoreWebView2Controller3* This, HWND parentWindow);
    HRESULT (*NotifyParentWindowPositionChanged)(ICoreWebView2Controller3* This);
    HRESULT (*Close)(ICoreWebView2Controller3* This);
    HRESULT (*get_CoreWebView2)(ICoreWebView2Controller3* This, ICoreWebView2** coreWebView2);
    HRESULT (*get_DefaultBackgroundColor)(ICoreWebView2Controller3* This, COREWEBVIEW2_COLOR* backgroundColor);
    HRESULT (*put_DefaultBackgroundColor)(ICoreWebView2Controller3* This, COREWEBVIEW2_COLOR backgroundColor);
    HRESULT (*get_RasterizationScale)(ICoreWebView2Controller3* This, double* scale);
    HRESULT (*put_RasterizationScale)(ICoreWebView2Controller3* This, double scale);
    HRESULT (*get_ShouldDetectMonitorScaleChanges)(ICoreWebView2Controller3* This, BOOL* value);
    HRESULT (*put_ShouldDetectMonitorScaleChanges)(ICoreWebView2Controller3* This, BOOL value);
    HRESULT (*add_RasterizationScaleChanged)(ICoreWebView2Controller3* This, ICoreWebView2RasterizationScaleChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_RasterizationScaleChanged)(ICoreWebView2Controller3* This, EventRegistrationToken token);
    HRESULT (*get_BoundsMode)(ICoreWebView2Controller3* This, COREWEBVIEW2_BOUNDS_MODE* boundsMode);
    HRESULT (*put_BoundsMode)(ICoreWebView2Controller3* This, COREWEBVIEW2_BOUNDS_MODE boundsMode);
} ICoreWebView2Controller3Vtbl;
struct ICoreWebView2Controller3
{
    struct ICoreWebView2Controller3Vtbl* lpVtbl;
};
typedef struct ICoreWebView2ContentLoadingEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2ContentLoadingEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2ContentLoadingEventArgs* This);
    ULONG (*Release)(ICoreWebView2ContentLoadingEventArgs* This);
    HRESULT (*get_IsErrorPage)(ICoreWebView2ContentLoadingEventArgs* This, BOOL* isErrorPage);
    HRESULT (*get_NavigationId)(ICoreWebView2ContentLoadingEventArgs* This, UINT64* navigationId);
} ICoreWebView2ContentLoadingEventArgsVtbl;
struct ICoreWebView2ContentLoadingEventArgs
{
    struct ICoreWebView2ContentLoadingEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2ContentLoadingEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2ContentLoadingEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2ContentLoadingEventHandler* This);
    ULONG (*Release)(ICoreWebView2ContentLoadingEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2ContentLoadingEventHandler* This, ICoreWebView2* sender, ICoreWebView2ContentLoadingEventArgs* args);
} ICoreWebView2ContentLoadingEventHandlerVtbl;
struct ICoreWebView2ContentLoadingEventHandler
{
    struct ICoreWebView2ContentLoadingEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2CookieVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2Cookie* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2Cookie* This);
    ULONG (*Release)(ICoreWebView2Cookie* This);
    HRESULT (*get_Name)(ICoreWebView2Cookie* This, LPWSTR* name);
    HRESULT (*get_Value)(ICoreWebView2Cookie* This, LPWSTR* value);
    HRESULT (*put_Value)(ICoreWebView2Cookie* This, LPCWSTR value);
    HRESULT (*get_Domain)(ICoreWebView2Cookie* This, LPWSTR* domain);
    HRESULT (*get_Path)(ICoreWebView2Cookie* This, LPWSTR* path);
    HRESULT (*get_Expires)(ICoreWebView2Cookie* This, double* expires);
    HRESULT (*put_Expires)(ICoreWebView2Cookie* This, double expires);
    HRESULT (*get_IsHttpOnly)(ICoreWebView2Cookie* This, BOOL* isHttpOnly);
    HRESULT (*put_IsHttpOnly)(ICoreWebView2Cookie* This, BOOL isHttpOnly);
    HRESULT (*get_SameSite)(ICoreWebView2Cookie* This, COREWEBVIEW2_COOKIE_SAME_SITE_KIND* sameSite);
    HRESULT (*put_SameSite)(ICoreWebView2Cookie* This, COREWEBVIEW2_COOKIE_SAME_SITE_KIND sameSite);
    HRESULT (*get_IsSecure)(ICoreWebView2Cookie* This, BOOL* isSecure);
    HRESULT (*put_IsSecure)(ICoreWebView2Cookie* This, BOOL isSecure);
    HRESULT (*get_IsSession)(ICoreWebView2Cookie* This, BOOL* isSession);
} ICoreWebView2CookieVtbl;
struct ICoreWebView2Cookie
{
    struct ICoreWebView2CookieVtbl* lpVtbl;
};
typedef struct ICoreWebView2CookieListVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2CookieList* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2CookieList* This);
    ULONG (*Release)(ICoreWebView2CookieList* This);
    HRESULT (*get_Count)(ICoreWebView2CookieList* This, UINT* count);
    HRESULT (*GetValueAtIndex)(ICoreWebView2CookieList* This, UINT index, ICoreWebView2Cookie** cookie);
} ICoreWebView2CookieListVtbl;
struct ICoreWebView2CookieList
{
    struct ICoreWebView2CookieListVtbl* lpVtbl;
};
typedef struct ICoreWebView2CookieManagerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2CookieManager* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2CookieManager* This);
    ULONG (*Release)(ICoreWebView2CookieManager* This);
    HRESULT (*CreateCookie)(ICoreWebView2CookieManager* This, LPCWSTR name, LPCWSTR value, LPCWSTR domain, LPCWSTR path, ICoreWebView2Cookie** cookie);
    HRESULT (*CopyCookie)(ICoreWebView2CookieManager* This, ICoreWebView2Cookie* cookieParam, ICoreWebView2Cookie** cookie);
    HRESULT (*GetCookies)(ICoreWebView2CookieManager* This, LPCWSTR uri, ICoreWebView2GetCookiesCompletedHandler* handler);
    HRESULT (*AddOrUpdateCookie)(ICoreWebView2CookieManager* This, ICoreWebView2Cookie* cookie);
    HRESULT (*DeleteCookie)(ICoreWebView2CookieManager* This, ICoreWebView2Cookie* cookie);
    HRESULT (*DeleteCookies)(ICoreWebView2CookieManager* This, LPCWSTR name, LPCWSTR uri);
    HRESULT (*DeleteCookiesWithDomainAndPath)(ICoreWebView2CookieManager* This, LPCWSTR name, LPCWSTR domain, LPCWSTR path);
    HRESULT (*DeleteAllCookies)(ICoreWebView2CookieManager* This);
} ICoreWebView2CookieManagerVtbl;
struct ICoreWebView2CookieManager
{
    struct ICoreWebView2CookieManagerVtbl* lpVtbl;
};
typedef struct ICoreWebView2CreateCoreWebView2CompositionControllerCompletedHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2CreateCoreWebView2CompositionControllerCompletedHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2CreateCoreWebView2CompositionControllerCompletedHandler* This);
    ULONG (*Release)(ICoreWebView2CreateCoreWebView2CompositionControllerCompletedHandler* This);
    HRESULT (*Invoke)(ICoreWebView2CreateCoreWebView2CompositionControllerCompletedHandler* This, HRESULT errorCode, ICoreWebView2CompositionController* webView);
} ICoreWebView2CreateCoreWebView2CompositionControllerCompletedHandlerVtbl;
struct ICoreWebView2CreateCoreWebView2CompositionControllerCompletedHandler
{
    struct ICoreWebView2CreateCoreWebView2CompositionControllerCompletedHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2CreateCoreWebView2ControllerCompletedHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2CreateCoreWebView2ControllerCompletedHandler* This);
    ULONG (*Release)(ICoreWebView2CreateCoreWebView2ControllerCompletedHandler* This);
    HRESULT (*Invoke)(ICoreWebView2CreateCoreWebView2ControllerCompletedHandler* This, HRESULT errorCode, ICoreWebView2Controller* createdController);
} ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl;
struct ICoreWebView2CreateCoreWebView2ControllerCompletedHandler
{
    struct ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler* This);
    ULONG (*Release)(ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler* This);
    HRESULT (*Invoke)(ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler* This, HRESULT errorCode, ICoreWebView2Environment* createdEnvironment);
} ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl;
struct ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler
{
    struct ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2ContainsFullScreenElementChangedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2ContainsFullScreenElementChangedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2ContainsFullScreenElementChangedEventHandler* This);
    ULONG (*Release)(ICoreWebView2ContainsFullScreenElementChangedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2ContainsFullScreenElementChangedEventHandler* This, ICoreWebView2* sender, IUnknown* args);
} ICoreWebView2ContainsFullScreenElementChangedEventHandlerVtbl;
struct ICoreWebView2ContainsFullScreenElementChangedEventHandler
{
    struct ICoreWebView2ContainsFullScreenElementChangedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2CursorChangedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2CursorChangedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2CursorChangedEventHandler* This);
    ULONG (*Release)(ICoreWebView2CursorChangedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2CursorChangedEventHandler* This, ICoreWebView2CompositionController* sender, IUnknown* args);
} ICoreWebView2CursorChangedEventHandlerVtbl;
struct ICoreWebView2CursorChangedEventHandler
{
    struct ICoreWebView2CursorChangedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2DocumentTitleChangedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2DocumentTitleChangedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2DocumentTitleChangedEventHandler* This);
    ULONG (*Release)(ICoreWebView2DocumentTitleChangedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2DocumentTitleChangedEventHandler* This, ICoreWebView2* sender, IUnknown* args);
} ICoreWebView2DocumentTitleChangedEventHandlerVtbl;
struct ICoreWebView2DocumentTitleChangedEventHandler
{
    struct ICoreWebView2DocumentTitleChangedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2DOMContentLoadedEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2DOMContentLoadedEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2DOMContentLoadedEventArgs* This);
    ULONG (*Release)(ICoreWebView2DOMContentLoadedEventArgs* This);
    HRESULT (*get_NavigationId)(ICoreWebView2DOMContentLoadedEventArgs* This, UINT64* navigationId);
} ICoreWebView2DOMContentLoadedEventArgsVtbl;
struct ICoreWebView2DOMContentLoadedEventArgs
{
    struct ICoreWebView2DOMContentLoadedEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2DOMContentLoadedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2DOMContentLoadedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2DOMContentLoadedEventHandler* This);
    ULONG (*Release)(ICoreWebView2DOMContentLoadedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2DOMContentLoadedEventHandler* This, ICoreWebView2* sender, ICoreWebView2DOMContentLoadedEventArgs* args);
} ICoreWebView2DOMContentLoadedEventHandlerVtbl;
struct ICoreWebView2DOMContentLoadedEventHandler
{
    struct ICoreWebView2DOMContentLoadedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2DeferralVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2Deferral* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2Deferral* This);
    ULONG (*Release)(ICoreWebView2Deferral* This);
    HRESULT (*Complete)(ICoreWebView2Deferral* This);
} ICoreWebView2DeferralVtbl;
struct ICoreWebView2Deferral
{
    struct ICoreWebView2DeferralVtbl* lpVtbl;
};
typedef struct ICoreWebView2DevToolsProtocolEventReceivedEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2DevToolsProtocolEventReceivedEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2DevToolsProtocolEventReceivedEventArgs* This);
    ULONG (*Release)(ICoreWebView2DevToolsProtocolEventReceivedEventArgs* This);
    HRESULT (*get_ParameterObjectAsJson)(ICoreWebView2DevToolsProtocolEventReceivedEventArgs* This, LPWSTR* parameterObjectAsJson);
} ICoreWebView2DevToolsProtocolEventReceivedEventArgsVtbl;
struct ICoreWebView2DevToolsProtocolEventReceivedEventArgs
{
    struct ICoreWebView2DevToolsProtocolEventReceivedEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2DevToolsProtocolEventReceivedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2DevToolsProtocolEventReceivedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2DevToolsProtocolEventReceivedEventHandler* This);
    ULONG (*Release)(ICoreWebView2DevToolsProtocolEventReceivedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2DevToolsProtocolEventReceivedEventHandler* This, ICoreWebView2* sender, ICoreWebView2DevToolsProtocolEventReceivedEventArgs* args);
} ICoreWebView2DevToolsProtocolEventReceivedEventHandlerVtbl;
struct ICoreWebView2DevToolsProtocolEventReceivedEventHandler
{
    struct ICoreWebView2DevToolsProtocolEventReceivedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2DevToolsProtocolEventReceiverVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2DevToolsProtocolEventReceiver* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2DevToolsProtocolEventReceiver* This);
    ULONG (*Release)(ICoreWebView2DevToolsProtocolEventReceiver* This);
    HRESULT (*add_DevToolsProtocolEventReceived)(ICoreWebView2DevToolsProtocolEventReceiver* This, ICoreWebView2DevToolsProtocolEventReceivedEventHandler* handler, EventRegistrationToken* token);
    HRESULT (*remove_DevToolsProtocolEventReceived)(ICoreWebView2DevToolsProtocolEventReceiver* This, EventRegistrationToken token);
} ICoreWebView2DevToolsProtocolEventReceiverVtbl;
struct ICoreWebView2DevToolsProtocolEventReceiver
{
    struct ICoreWebView2DevToolsProtocolEventReceiverVtbl* lpVtbl;
};
typedef struct ICoreWebView2EnvironmentVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2Environment* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2Environment* This);
    ULONG (*Release)(ICoreWebView2Environment* This);
    HRESULT (*CreateCoreWebView2Controller)(ICoreWebView2Environment* This, HWND parentWindow, ICoreWebView2CreateCoreWebView2ControllerCompletedHandler* handler);
    HRESULT (*CreateWebResourceResponse)(ICoreWebView2Environment* This, IStream* content, int statusCode, LPCWSTR reasonPhrase, LPCWSTR headers, ICoreWebView2WebResourceResponse** response);
    HRESULT (*get_BrowserVersionString)(ICoreWebView2Environment* This, LPWSTR* versionInfo);
    HRESULT (*add_NewBrowserVersionAvailable)(ICoreWebView2Environment* This, ICoreWebView2NewBrowserVersionAvailableEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_NewBrowserVersionAvailable)(ICoreWebView2Environment* This, EventRegistrationToken token);
} ICoreWebView2EnvironmentVtbl;
struct ICoreWebView2Environment
{
    struct ICoreWebView2EnvironmentVtbl* lpVtbl;
};
typedef struct ICoreWebView2Environment2Vtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2Environment2* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2Environment2* This);
    ULONG (*Release)(ICoreWebView2Environment2* This);
    HRESULT (*CreateCoreWebView2Controller)(ICoreWebView2Environment2* This, HWND parentWindow, ICoreWebView2CreateCoreWebView2ControllerCompletedHandler* handler);
    HRESULT (*CreateWebResourceResponse)(ICoreWebView2Environment2* This, IStream* content, int statusCode, LPCWSTR reasonPhrase, LPCWSTR headers, ICoreWebView2WebResourceResponse** response);
    HRESULT (*get_BrowserVersionString)(ICoreWebView2Environment2* This, LPWSTR* versionInfo);
    HRESULT (*add_NewBrowserVersionAvailable)(ICoreWebView2Environment2* This, ICoreWebView2NewBrowserVersionAvailableEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_NewBrowserVersionAvailable)(ICoreWebView2Environment2* This, EventRegistrationToken token);
    HRESULT (*CreateWebResourceRequest)(ICoreWebView2Environment2* This, LPCWSTR uri, LPCWSTR method, IStream* postData, LPCWSTR headers, ICoreWebView2WebResourceRequest** request);
} ICoreWebView2Environment2Vtbl;
struct ICoreWebView2Environment2
{
    struct ICoreWebView2Environment2Vtbl* lpVtbl;
};
typedef struct ICoreWebView2Environment3Vtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2Environment3* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2Environment3* This);
    ULONG (*Release)(ICoreWebView2Environment3* This);
    HRESULT (*CreateCoreWebView2Controller)(ICoreWebView2Environment3* This, HWND parentWindow, ICoreWebView2CreateCoreWebView2ControllerCompletedHandler* handler);
    HRESULT (*CreateWebResourceResponse)(ICoreWebView2Environment3* This, IStream* content, int statusCode, LPCWSTR reasonPhrase, LPCWSTR headers, ICoreWebView2WebResourceResponse** response);
    HRESULT (*get_BrowserVersionString)(ICoreWebView2Environment3* This, LPWSTR* versionInfo);
    HRESULT (*add_NewBrowserVersionAvailable)(ICoreWebView2Environment3* This, ICoreWebView2NewBrowserVersionAvailableEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_NewBrowserVersionAvailable)(ICoreWebView2Environment3* This, EventRegistrationToken token);
    HRESULT (*CreateWebResourceRequest)(ICoreWebView2Environment3* This, LPCWSTR uri, LPCWSTR method, IStream* postData, LPCWSTR headers, ICoreWebView2WebResourceRequest** request);
    HRESULT (*CreateCoreWebView2CompositionController)(ICoreWebView2Environment3* This, HWND parentWindow, ICoreWebView2CreateCoreWebView2CompositionControllerCompletedHandler* handler);
    HRESULT (*CreateCoreWebView2PointerInfo)(ICoreWebView2Environment3* This, ICoreWebView2PointerInfo** pointerInfo);
} ICoreWebView2Environment3Vtbl;
struct ICoreWebView2Environment3
{
    struct ICoreWebView2Environment3Vtbl* lpVtbl;
};
typedef struct ICoreWebView2Environment4Vtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2Environment4* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2Environment4* This);
    ULONG (*Release)(ICoreWebView2Environment4* This);
    HRESULT (*CreateCoreWebView2Controller)(ICoreWebView2Environment4* This, HWND parentWindow, ICoreWebView2CreateCoreWebView2ControllerCompletedHandler* handler);
    HRESULT (*CreateWebResourceResponse)(ICoreWebView2Environment4* This, IStream* content, int statusCode, LPCWSTR reasonPhrase, LPCWSTR headers, ICoreWebView2WebResourceResponse** response);
    HRESULT (*get_BrowserVersionString)(ICoreWebView2Environment4* This, LPWSTR* versionInfo);
    HRESULT (*add_NewBrowserVersionAvailable)(ICoreWebView2Environment4* This, ICoreWebView2NewBrowserVersionAvailableEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT (*remove_NewBrowserVersionAvailable)(ICoreWebView2Environment4* This, EventRegistrationToken token);
    HRESULT (*CreateWebResourceRequest)(ICoreWebView2Environment4* This, LPCWSTR uri, LPCWSTR method, IStream* postData, LPCWSTR headers, ICoreWebView2WebResourceRequest** request);
    HRESULT (*CreateCoreWebView2CompositionController)(ICoreWebView2Environment4* This, HWND parentWindow, ICoreWebView2CreateCoreWebView2CompositionControllerCompletedHandler* handler);
    HRESULT (*CreateCoreWebView2PointerInfo)(ICoreWebView2Environment4* This, ICoreWebView2PointerInfo** pointerInfo);
    HRESULT (*GetProviderForHwnd)(ICoreWebView2Environment4* This, HWND hwnd, IUnknown** provider);
} ICoreWebView2Environment4Vtbl;
struct ICoreWebView2Environment4
{
    struct ICoreWebView2Environment4Vtbl* lpVtbl;
};
typedef struct ICoreWebView2EnvironmentOptionsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2EnvironmentOptions* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2EnvironmentOptions* This);
    ULONG (*Release)(ICoreWebView2EnvironmentOptions* This);
    HRESULT (*get_AdditionalBrowserArguments)(ICoreWebView2EnvironmentOptions* This, LPWSTR* value);
    HRESULT (*put_AdditionalBrowserArguments)(ICoreWebView2EnvironmentOptions* This, LPCWSTR value);
    HRESULT (*get_Language)(ICoreWebView2EnvironmentOptions* This, LPWSTR* value);
    HRESULT (*put_Language)(ICoreWebView2EnvironmentOptions* This, LPCWSTR value);
    HRESULT (*get_TargetCompatibleBrowserVersion)(ICoreWebView2EnvironmentOptions* This, LPWSTR* value);
    HRESULT (*put_TargetCompatibleBrowserVersion)(ICoreWebView2EnvironmentOptions* This, LPCWSTR value);
    HRESULT (*get_AllowSingleSignOnUsingOSPrimaryAccount)(ICoreWebView2EnvironmentOptions* This, BOOL* allow);
    HRESULT (*put_AllowSingleSignOnUsingOSPrimaryAccount)(ICoreWebView2EnvironmentOptions* This, BOOL allow);
} ICoreWebView2EnvironmentOptionsVtbl;
struct ICoreWebView2EnvironmentOptions
{
    struct ICoreWebView2EnvironmentOptionsVtbl* lpVtbl;
};
typedef struct ICoreWebView2ExecuteScriptCompletedHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2ExecuteScriptCompletedHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2ExecuteScriptCompletedHandler* This);
    ULONG (*Release)(ICoreWebView2ExecuteScriptCompletedHandler* This);
    HRESULT (*Invoke)(ICoreWebView2ExecuteScriptCompletedHandler* This, HRESULT errorCode, LPCWSTR resultObjectAsJson);
} ICoreWebView2ExecuteScriptCompletedHandlerVtbl;
struct ICoreWebView2ExecuteScriptCompletedHandler
{
    struct ICoreWebView2ExecuteScriptCompletedHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2FocusChangedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2FocusChangedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2FocusChangedEventHandler* This);
    ULONG (*Release)(ICoreWebView2FocusChangedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2FocusChangedEventHandler* This, ICoreWebView2Controller* sender, IUnknown* args);
} ICoreWebView2FocusChangedEventHandlerVtbl;
struct ICoreWebView2FocusChangedEventHandler
{
    struct ICoreWebView2FocusChangedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2GetCookiesCompletedHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2GetCookiesCompletedHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2GetCookiesCompletedHandler* This);
    ULONG (*Release)(ICoreWebView2GetCookiesCompletedHandler* This);
    HRESULT (*Invoke)(ICoreWebView2GetCookiesCompletedHandler* This, HRESULT result, ICoreWebView2CookieList* cookieList);
} ICoreWebView2GetCookiesCompletedHandlerVtbl;
struct ICoreWebView2GetCookiesCompletedHandler
{
    struct ICoreWebView2GetCookiesCompletedHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2HistoryChangedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2HistoryChangedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2HistoryChangedEventHandler* This);
    ULONG (*Release)(ICoreWebView2HistoryChangedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2HistoryChangedEventHandler* This, ICoreWebView2* sender, IUnknown* args);
} ICoreWebView2HistoryChangedEventHandlerVtbl;
struct ICoreWebView2HistoryChangedEventHandler
{
    struct ICoreWebView2HistoryChangedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2HttpHeadersCollectionIteratorVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2HttpHeadersCollectionIterator* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2HttpHeadersCollectionIterator* This);
    ULONG (*Release)(ICoreWebView2HttpHeadersCollectionIterator* This);
    HRESULT (*GetCurrentHeader)(ICoreWebView2HttpHeadersCollectionIterator* This, LPWSTR* name, LPWSTR* value);
    HRESULT (*get_HasCurrentHeader)(ICoreWebView2HttpHeadersCollectionIterator* This, BOOL* hasCurrent);
    HRESULT (*MoveNext)(ICoreWebView2HttpHeadersCollectionIterator* This, BOOL* hasNext);
} ICoreWebView2HttpHeadersCollectionIteratorVtbl;
struct ICoreWebView2HttpHeadersCollectionIterator
{
    struct ICoreWebView2HttpHeadersCollectionIteratorVtbl* lpVtbl;
};
typedef struct ICoreWebView2HttpRequestHeadersVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2HttpRequestHeaders* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2HttpRequestHeaders* This);
    ULONG (*Release)(ICoreWebView2HttpRequestHeaders* This);
    HRESULT (*GetHeader)(ICoreWebView2HttpRequestHeaders* This, LPCWSTR name, LPWSTR* value);
    HRESULT (*GetHeaders)(ICoreWebView2HttpRequestHeaders* This, LPCWSTR name, ICoreWebView2HttpHeadersCollectionIterator** iterator);
    HRESULT (*Contains)(ICoreWebView2HttpRequestHeaders* This, LPCWSTR name, BOOL* contains);
    HRESULT (*SetHeader)(ICoreWebView2HttpRequestHeaders* This, LPCWSTR name, LPCWSTR value);
    HRESULT (*RemoveHeader)(ICoreWebView2HttpRequestHeaders* This, LPCWSTR name);
    HRESULT (*GetIterator)(ICoreWebView2HttpRequestHeaders* This, ICoreWebView2HttpHeadersCollectionIterator** iterator);
} ICoreWebView2HttpRequestHeadersVtbl;
struct ICoreWebView2HttpRequestHeaders
{
    struct ICoreWebView2HttpRequestHeadersVtbl* lpVtbl;
};
typedef struct ICoreWebView2HttpResponseHeadersVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2HttpResponseHeaders* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2HttpResponseHeaders* This);
    ULONG (*Release)(ICoreWebView2HttpResponseHeaders* This);
    HRESULT (*AppendHeader)(ICoreWebView2HttpResponseHeaders* This, LPCWSTR name, LPCWSTR value);
    HRESULT (*Contains)(ICoreWebView2HttpResponseHeaders* This, LPCWSTR name, BOOL* contains);
    HRESULT (*GetHeader)(ICoreWebView2HttpResponseHeaders* This, LPCWSTR name, LPWSTR* value);
    HRESULT (*GetHeaders)(ICoreWebView2HttpResponseHeaders* This, LPCWSTR name, ICoreWebView2HttpHeadersCollectionIterator** iterator);
    HRESULT (*GetIterator)(ICoreWebView2HttpResponseHeaders* This, ICoreWebView2HttpHeadersCollectionIterator** iterator);
} ICoreWebView2HttpResponseHeadersVtbl;
struct ICoreWebView2HttpResponseHeaders
{
    struct ICoreWebView2HttpResponseHeadersVtbl* lpVtbl;
};
typedef struct ICoreWebView2InteropVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2Interop* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2Interop* This);
    ULONG (*Release)(ICoreWebView2Interop* This);
    HRESULT (*AddHostObjectToScript)(ICoreWebView2Interop* This, LPCWSTR name, VARIANT* object);
} ICoreWebView2InteropVtbl;
struct ICoreWebView2Interop
{
    struct ICoreWebView2InteropVtbl* lpVtbl;
};
typedef struct ICoreWebView2MoveFocusRequestedEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2MoveFocusRequestedEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2MoveFocusRequestedEventArgs* This);
    ULONG (*Release)(ICoreWebView2MoveFocusRequestedEventArgs* This);
    HRESULT (*get_Reason)(ICoreWebView2MoveFocusRequestedEventArgs* This, COREWEBVIEW2_MOVE_FOCUS_REASON* reason);
    HRESULT (*get_Handled)(ICoreWebView2MoveFocusRequestedEventArgs* This, BOOL* value);
    HRESULT (*put_Handled)(ICoreWebView2MoveFocusRequestedEventArgs* This, BOOL value);
} ICoreWebView2MoveFocusRequestedEventArgsVtbl;
struct ICoreWebView2MoveFocusRequestedEventArgs
{
    struct ICoreWebView2MoveFocusRequestedEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2MoveFocusRequestedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2MoveFocusRequestedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2MoveFocusRequestedEventHandler* This);
    ULONG (*Release)(ICoreWebView2MoveFocusRequestedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2MoveFocusRequestedEventHandler* This, ICoreWebView2Controller* sender, ICoreWebView2MoveFocusRequestedEventArgs* args);
} ICoreWebView2MoveFocusRequestedEventHandlerVtbl;
struct ICoreWebView2MoveFocusRequestedEventHandler
{
    struct ICoreWebView2MoveFocusRequestedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2NavigationCompletedEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2NavigationCompletedEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2NavigationCompletedEventArgs* This);
    ULONG (*Release)(ICoreWebView2NavigationCompletedEventArgs* This);
    HRESULT (*get_IsSuccess)(ICoreWebView2NavigationCompletedEventArgs* This, BOOL* isSuccess);
    HRESULT (*get_WebErrorStatus)(ICoreWebView2NavigationCompletedEventArgs* This, COREWEBVIEW2_WEB_ERROR_STATUS* webErrorStatus);
    HRESULT (*get_NavigationId)(ICoreWebView2NavigationCompletedEventArgs* This, UINT64* navigationId);
} ICoreWebView2NavigationCompletedEventArgsVtbl;
struct ICoreWebView2NavigationCompletedEventArgs
{
    struct ICoreWebView2NavigationCompletedEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2NavigationCompletedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2NavigationCompletedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2NavigationCompletedEventHandler* This);
    ULONG (*Release)(ICoreWebView2NavigationCompletedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2NavigationCompletedEventHandler* This, ICoreWebView2* sender, ICoreWebView2NavigationCompletedEventArgs* args);
} ICoreWebView2NavigationCompletedEventHandlerVtbl;
struct ICoreWebView2NavigationCompletedEventHandler
{
    struct ICoreWebView2NavigationCompletedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2NavigationStartingEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2NavigationStartingEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2NavigationStartingEventArgs* This);
    ULONG (*Release)(ICoreWebView2NavigationStartingEventArgs* This);
    HRESULT (*get_Uri)(ICoreWebView2NavigationStartingEventArgs* This, LPWSTR* uri);
    HRESULT (*get_IsUserInitiated)(ICoreWebView2NavigationStartingEventArgs* This, BOOL* isUserInitiated);
    HRESULT (*get_IsRedirected)(ICoreWebView2NavigationStartingEventArgs* This, BOOL* isRedirected);
    HRESULT (*get_RequestHeaders)(ICoreWebView2NavigationStartingEventArgs* This, ICoreWebView2HttpRequestHeaders** requestHeaders);
    HRESULT (*get_Cancel)(ICoreWebView2NavigationStartingEventArgs* This, BOOL* cancel);
    HRESULT (*put_Cancel)(ICoreWebView2NavigationStartingEventArgs* This, BOOL cancel);
    HRESULT (*get_NavigationId)(ICoreWebView2NavigationStartingEventArgs* This, UINT64* navigationId);
} ICoreWebView2NavigationStartingEventArgsVtbl;
struct ICoreWebView2NavigationStartingEventArgs
{
    struct ICoreWebView2NavigationStartingEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2NavigationStartingEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2NavigationStartingEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2NavigationStartingEventHandler* This);
    ULONG (*Release)(ICoreWebView2NavigationStartingEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2NavigationStartingEventHandler* This, ICoreWebView2* sender, ICoreWebView2NavigationStartingEventArgs* args);
} ICoreWebView2NavigationStartingEventHandlerVtbl;
struct ICoreWebView2NavigationStartingEventHandler
{
    struct ICoreWebView2NavigationStartingEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2NewBrowserVersionAvailableEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2NewBrowserVersionAvailableEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2NewBrowserVersionAvailableEventHandler* This);
    ULONG (*Release)(ICoreWebView2NewBrowserVersionAvailableEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2NewBrowserVersionAvailableEventHandler* This, ICoreWebView2Environment* sender, IUnknown* args);
} ICoreWebView2NewBrowserVersionAvailableEventHandlerVtbl;
struct ICoreWebView2NewBrowserVersionAvailableEventHandler
{
    struct ICoreWebView2NewBrowserVersionAvailableEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2NewWindowRequestedEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2NewWindowRequestedEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2NewWindowRequestedEventArgs* This);
    ULONG (*Release)(ICoreWebView2NewWindowRequestedEventArgs* This);
    HRESULT (*get_Uri)(ICoreWebView2NewWindowRequestedEventArgs* This, LPWSTR* uri);
    HRESULT (*put_NewWindow)(ICoreWebView2NewWindowRequestedEventArgs* This, ICoreWebView2* newWindow);
    HRESULT (*get_NewWindow)(ICoreWebView2NewWindowRequestedEventArgs* This, ICoreWebView2** newWindow);
    HRESULT (*put_Handled)(ICoreWebView2NewWindowRequestedEventArgs* This, BOOL handled);
    HRESULT (*get_Handled)(ICoreWebView2NewWindowRequestedEventArgs* This, BOOL* handled);
    HRESULT (*get_IsUserInitiated)(ICoreWebView2NewWindowRequestedEventArgs* This, BOOL* isUserInitiated);
    HRESULT (*GetDeferral)(ICoreWebView2NewWindowRequestedEventArgs* This, ICoreWebView2Deferral** deferral);
    HRESULT (*get_WindowFeatures)(ICoreWebView2NewWindowRequestedEventArgs* This, ICoreWebView2WindowFeatures** value);
} ICoreWebView2NewWindowRequestedEventArgsVtbl;
struct ICoreWebView2NewWindowRequestedEventArgs
{
    struct ICoreWebView2NewWindowRequestedEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2NewWindowRequestedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2NewWindowRequestedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2NewWindowRequestedEventHandler* This);
    ULONG (*Release)(ICoreWebView2NewWindowRequestedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2NewWindowRequestedEventHandler* This, ICoreWebView2* sender, ICoreWebView2NewWindowRequestedEventArgs* args);
} ICoreWebView2NewWindowRequestedEventHandlerVtbl;
struct ICoreWebView2NewWindowRequestedEventHandler
{
    struct ICoreWebView2NewWindowRequestedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2PermissionRequestedEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2PermissionRequestedEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2PermissionRequestedEventArgs* This);
    ULONG (*Release)(ICoreWebView2PermissionRequestedEventArgs* This);
    HRESULT (*get_Uri)(ICoreWebView2PermissionRequestedEventArgs* This, LPWSTR* uri);
    HRESULT (*get_PermissionKind)(ICoreWebView2PermissionRequestedEventArgs* This, COREWEBVIEW2_PERMISSION_KIND* permissionKind);
    HRESULT (*get_IsUserInitiated)(ICoreWebView2PermissionRequestedEventArgs* This, BOOL* isUserInitiated);
    HRESULT (*get_State)(ICoreWebView2PermissionRequestedEventArgs* This, COREWEBVIEW2_PERMISSION_STATE* state);
    HRESULT (*put_State)(ICoreWebView2PermissionRequestedEventArgs* This, COREWEBVIEW2_PERMISSION_STATE state);
    HRESULT (*GetDeferral)(ICoreWebView2PermissionRequestedEventArgs* This, ICoreWebView2Deferral** deferral);
} ICoreWebView2PermissionRequestedEventArgsVtbl;
struct ICoreWebView2PermissionRequestedEventArgs
{
    struct ICoreWebView2PermissionRequestedEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2PermissionRequestedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2PermissionRequestedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2PermissionRequestedEventHandler* This);
    ULONG (*Release)(ICoreWebView2PermissionRequestedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2PermissionRequestedEventHandler* This, ICoreWebView2* sender, ICoreWebView2PermissionRequestedEventArgs* args);
} ICoreWebView2PermissionRequestedEventHandlerVtbl;
struct ICoreWebView2PermissionRequestedEventHandler
{
    struct ICoreWebView2PermissionRequestedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2PointerInfoVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2PointerInfo* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2PointerInfo* This);
    ULONG (*Release)(ICoreWebView2PointerInfo* This);
    HRESULT (*get_PointerKind)(ICoreWebView2PointerInfo* This, DWORD* pointerKind);
    HRESULT (*put_PointerKind)(ICoreWebView2PointerInfo* This, DWORD pointerKind);
    HRESULT (*get_PointerId)(ICoreWebView2PointerInfo* This, UINT32* pointerId);
    HRESULT (*put_PointerId)(ICoreWebView2PointerInfo* This, UINT32 pointerId);
    HRESULT (*get_FrameId)(ICoreWebView2PointerInfo* This, UINT32* frameId);
    HRESULT (*put_FrameId)(ICoreWebView2PointerInfo* This, UINT32 frameId);
    HRESULT (*get_PointerFlags)(ICoreWebView2PointerInfo* This, UINT32* pointerFlags);
    HRESULT (*put_PointerFlags)(ICoreWebView2PointerInfo* This, UINT32 pointerFlags);
    HRESULT (*get_PointerDeviceRect)(ICoreWebView2PointerInfo* This, RECT* pointerDeviceRect);
    HRESULT (*put_PointerDeviceRect)(ICoreWebView2PointerInfo* This, RECT pointerDeviceRect);
    HRESULT (*get_DisplayRect)(ICoreWebView2PointerInfo* This, RECT* displayRect);
    HRESULT (*put_DisplayRect)(ICoreWebView2PointerInfo* This, RECT displayRect);
    HRESULT (*get_PixelLocation)(ICoreWebView2PointerInfo* This, POINT* pixelLocation);
    HRESULT (*put_PixelLocation)(ICoreWebView2PointerInfo* This, POINT pixelLocation);
    HRESULT (*get_HimetricLocation)(ICoreWebView2PointerInfo* This, POINT* himetricLocation);
    HRESULT (*put_HimetricLocation)(ICoreWebView2PointerInfo* This, POINT himetricLocation);
    HRESULT (*get_PixelLocationRaw)(ICoreWebView2PointerInfo* This, POINT* pixelLocationRaw);
    HRESULT (*put_PixelLocationRaw)(ICoreWebView2PointerInfo* This, POINT pixelLocationRaw);
    HRESULT (*get_HimetricLocationRaw)(ICoreWebView2PointerInfo* This, POINT* himetricLocationRaw);
    HRESULT (*put_HimetricLocationRaw)(ICoreWebView2PointerInfo* This, POINT himetricLocationRaw);
    HRESULT (*get_Time)(ICoreWebView2PointerInfo* This, DWORD* time);
    HRESULT (*put_Time)(ICoreWebView2PointerInfo* This, DWORD time);
    HRESULT (*get_HistoryCount)(ICoreWebView2PointerInfo* This, UINT32* historyCount);
    HRESULT (*put_HistoryCount)(ICoreWebView2PointerInfo* This, UINT32 historyCount);
    HRESULT (*get_InputData)(ICoreWebView2PointerInfo* This, INT32* inputData);
    HRESULT (*put_InputData)(ICoreWebView2PointerInfo* This, INT32 inputData);
    HRESULT (*get_KeyStates)(ICoreWebView2PointerInfo* This, DWORD* keyStates);
    HRESULT (*put_KeyStates)(ICoreWebView2PointerInfo* This, DWORD keyStates);
    HRESULT (*get_PerformanceCount)(ICoreWebView2PointerInfo* This, UINT64* performanceCount);
    HRESULT (*put_PerformanceCount)(ICoreWebView2PointerInfo* This, UINT64 performanceCount);
    HRESULT (*get_ButtonChangeKind)(ICoreWebView2PointerInfo* This, INT32* buttonChangeKind);
    HRESULT (*put_ButtonChangeKind)(ICoreWebView2PointerInfo* This, INT32 buttonChangeKind);
    HRESULT (*get_PenFlags)(ICoreWebView2PointerInfo* This, UINT32* penFLags);
    HRESULT (*put_PenFlags)(ICoreWebView2PointerInfo* This, UINT32 penFLags);
    HRESULT (*get_PenMask)(ICoreWebView2PointerInfo* This, UINT32* penMask);
    HRESULT (*put_PenMask)(ICoreWebView2PointerInfo* This, UINT32 penMask);
    HRESULT (*get_PenPressure)(ICoreWebView2PointerInfo* This, UINT32* penPressure);
    HRESULT (*put_PenPressure)(ICoreWebView2PointerInfo* This, UINT32 penPressure);
    HRESULT (*get_PenRotation)(ICoreWebView2PointerInfo* This, UINT32* penRotation);
    HRESULT (*put_PenRotation)(ICoreWebView2PointerInfo* This, UINT32 penRotation);
    HRESULT (*get_PenTiltX)(ICoreWebView2PointerInfo* This, INT32* penTiltX);
    HRESULT (*put_PenTiltX)(ICoreWebView2PointerInfo* This, INT32 penTiltX);
    HRESULT (*get_PenTiltY)(ICoreWebView2PointerInfo* This, INT32* penTiltY);
    HRESULT (*put_PenTiltY)(ICoreWebView2PointerInfo* This, INT32 penTiltY);
    HRESULT (*get_TouchFlags)(ICoreWebView2PointerInfo* This, UINT32* touchFlags);
    HRESULT (*put_TouchFlags)(ICoreWebView2PointerInfo* This, UINT32 touchFlags);
    HRESULT (*get_TouchMask)(ICoreWebView2PointerInfo* This, UINT32* touchMask);
    HRESULT (*put_TouchMask)(ICoreWebView2PointerInfo* This, UINT32 touchMask);
    HRESULT (*get_TouchContact)(ICoreWebView2PointerInfo* This, RECT* touchContact);
    HRESULT (*put_TouchContact)(ICoreWebView2PointerInfo* This, RECT touchContact);
    HRESULT (*get_TouchContactRaw)(ICoreWebView2PointerInfo* This, RECT* touchContactRaw);
    HRESULT (*put_TouchContactRaw)(ICoreWebView2PointerInfo* This, RECT touchContactRaw);
    HRESULT (*get_TouchOrientation)(ICoreWebView2PointerInfo* This, UINT32* touchOrientation);
    HRESULT (*put_TouchOrientation)(ICoreWebView2PointerInfo* This, UINT32 touchOrientation);
    HRESULT (*get_TouchPressure)(ICoreWebView2PointerInfo* This, UINT32* touchPressure);
    HRESULT (*put_TouchPressure)(ICoreWebView2PointerInfo* This, UINT32 touchPressure);
} ICoreWebView2PointerInfoVtbl;
struct ICoreWebView2PointerInfo
{
    struct ICoreWebView2PointerInfoVtbl* lpVtbl;
};
typedef struct ICoreWebView2ProcessFailedEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2ProcessFailedEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2ProcessFailedEventArgs* This);
    ULONG (*Release)(ICoreWebView2ProcessFailedEventArgs* This);
    HRESULT (*get_ProcessFailedKind)(ICoreWebView2ProcessFailedEventArgs* This, COREWEBVIEW2_PROCESS_FAILED_KIND* processFailedKind);
} ICoreWebView2ProcessFailedEventArgsVtbl;
struct ICoreWebView2ProcessFailedEventArgs
{
    struct ICoreWebView2ProcessFailedEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2ProcessFailedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2ProcessFailedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2ProcessFailedEventHandler* This);
    ULONG (*Release)(ICoreWebView2ProcessFailedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2ProcessFailedEventHandler* This, ICoreWebView2* sender, ICoreWebView2ProcessFailedEventArgs* args);
} ICoreWebView2ProcessFailedEventHandlerVtbl;
struct ICoreWebView2ProcessFailedEventHandler
{
    struct ICoreWebView2ProcessFailedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2RasterizationScaleChangedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2RasterizationScaleChangedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2RasterizationScaleChangedEventHandler* This);
    ULONG (*Release)(ICoreWebView2RasterizationScaleChangedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2RasterizationScaleChangedEventHandler* This, ICoreWebView2Controller* sender, IUnknown* args);
} ICoreWebView2RasterizationScaleChangedEventHandlerVtbl;
struct ICoreWebView2RasterizationScaleChangedEventHandler
{
    struct ICoreWebView2RasterizationScaleChangedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2ScriptDialogOpeningEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2ScriptDialogOpeningEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2ScriptDialogOpeningEventArgs* This);
    ULONG (*Release)(ICoreWebView2ScriptDialogOpeningEventArgs* This);
    HRESULT (*get_Uri)(ICoreWebView2ScriptDialogOpeningEventArgs* This, LPWSTR* uri);
    HRESULT (*get_Kind)(ICoreWebView2ScriptDialogOpeningEventArgs* This, COREWEBVIEW2_SCRIPT_DIALOG_KIND* kind);
    HRESULT (*get_Message)(ICoreWebView2ScriptDialogOpeningEventArgs* This, LPWSTR* message);
    HRESULT (*Accept)(ICoreWebView2ScriptDialogOpeningEventArgs* This);
    HRESULT (*get_DefaultText)(ICoreWebView2ScriptDialogOpeningEventArgs* This, LPWSTR* defaultText);
    HRESULT (*get_ResultText)(ICoreWebView2ScriptDialogOpeningEventArgs* This, LPWSTR* resultText);
    HRESULT (*put_ResultText)(ICoreWebView2ScriptDialogOpeningEventArgs* This, LPCWSTR resultText);
    HRESULT (*GetDeferral)(ICoreWebView2ScriptDialogOpeningEventArgs* This, ICoreWebView2Deferral** deferral);
} ICoreWebView2ScriptDialogOpeningEventArgsVtbl;
struct ICoreWebView2ScriptDialogOpeningEventArgs
{
    struct ICoreWebView2ScriptDialogOpeningEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2ScriptDialogOpeningEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2ScriptDialogOpeningEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2ScriptDialogOpeningEventHandler* This);
    ULONG (*Release)(ICoreWebView2ScriptDialogOpeningEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2ScriptDialogOpeningEventHandler* This, ICoreWebView2* sender, ICoreWebView2ScriptDialogOpeningEventArgs* args);
} ICoreWebView2ScriptDialogOpeningEventHandlerVtbl;
struct ICoreWebView2ScriptDialogOpeningEventHandler
{
    struct ICoreWebView2ScriptDialogOpeningEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2SettingsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2Settings* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2Settings* This);
    ULONG (*Release)(ICoreWebView2Settings* This);
    HRESULT (*get_IsScriptEnabled)(ICoreWebView2Settings* This, BOOL* isScriptEnabled);
    HRESULT (*put_IsScriptEnabled)(ICoreWebView2Settings* This, BOOL isScriptEnabled);
    HRESULT (*get_IsWebMessageEnabled)(ICoreWebView2Settings* This, BOOL* isWebMessageEnabled);
    HRESULT (*put_IsWebMessageEnabled)(ICoreWebView2Settings* This, BOOL isWebMessageEnabled);
    HRESULT (*get_AreDefaultScriptDialogsEnabled)(ICoreWebView2Settings* This, BOOL* areDefaultScriptDialogsEnabled);
    HRESULT (*put_AreDefaultScriptDialogsEnabled)(ICoreWebView2Settings* This, BOOL areDefaultScriptDialogsEnabled);
    HRESULT (*get_IsStatusBarEnabled)(ICoreWebView2Settings* This, BOOL* isStatusBarEnabled);
    HRESULT (*put_IsStatusBarEnabled)(ICoreWebView2Settings* This, BOOL isStatusBarEnabled);
    HRESULT (*get_AreDevToolsEnabled)(ICoreWebView2Settings* This, BOOL* areDevToolsEnabled);
    HRESULT (*put_AreDevToolsEnabled)(ICoreWebView2Settings* This, BOOL areDevToolsEnabled);
    HRESULT (*get_AreDefaultContextMenusEnabled)(ICoreWebView2Settings* This, BOOL* enabled);
    HRESULT (*put_AreDefaultContextMenusEnabled)(ICoreWebView2Settings* This, BOOL enabled);
    HRESULT (*get_AreHostObjectsAllowed)(ICoreWebView2Settings* This, BOOL* allowed);
    HRESULT (*put_AreHostObjectsAllowed)(ICoreWebView2Settings* This, BOOL allowed);
    HRESULT (*get_IsZoomControlEnabled)(ICoreWebView2Settings* This, BOOL* enabled);
    HRESULT (*put_IsZoomControlEnabled)(ICoreWebView2Settings* This, BOOL enabled);
    HRESULT (*get_IsBuiltInErrorPageEnabled)(ICoreWebView2Settings* This, BOOL* enabled);
    HRESULT (*put_IsBuiltInErrorPageEnabled)(ICoreWebView2Settings* This, BOOL enabled);
} ICoreWebView2SettingsVtbl;
struct ICoreWebView2Settings
{
    struct ICoreWebView2SettingsVtbl* lpVtbl;
};
typedef struct ICoreWebView2SourceChangedEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2SourceChangedEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2SourceChangedEventArgs* This);
    ULONG (*Release)(ICoreWebView2SourceChangedEventArgs* This);
    HRESULT (*get_IsNewDocument)(ICoreWebView2SourceChangedEventArgs* This, BOOL* isNewDocument);
} ICoreWebView2SourceChangedEventArgsVtbl;
struct ICoreWebView2SourceChangedEventArgs
{
    struct ICoreWebView2SourceChangedEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2SourceChangedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2SourceChangedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2SourceChangedEventHandler* This);
    ULONG (*Release)(ICoreWebView2SourceChangedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2SourceChangedEventHandler* This, ICoreWebView2* sender, ICoreWebView2SourceChangedEventArgs* args);
} ICoreWebView2SourceChangedEventHandlerVtbl;
struct ICoreWebView2SourceChangedEventHandler
{
    struct ICoreWebView2SourceChangedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2TrySuspendCompletedHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2TrySuspendCompletedHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2TrySuspendCompletedHandler* This);
    ULONG (*Release)(ICoreWebView2TrySuspendCompletedHandler* This);
    HRESULT (*Invoke)(ICoreWebView2TrySuspendCompletedHandler* This, HRESULT errorCode, BOOL isSuccessful);
} ICoreWebView2TrySuspendCompletedHandlerVtbl;
struct ICoreWebView2TrySuspendCompletedHandler
{
    struct ICoreWebView2TrySuspendCompletedHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2WebMessageReceivedEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2WebMessageReceivedEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2WebMessageReceivedEventArgs* This);
    ULONG (*Release)(ICoreWebView2WebMessageReceivedEventArgs* This);
    HRESULT (*get_Source)(ICoreWebView2WebMessageReceivedEventArgs* This, LPWSTR* source);
    HRESULT (*get_WebMessageAsJson)(ICoreWebView2WebMessageReceivedEventArgs* This, LPWSTR* webMessageAsJson);
    HRESULT (*TryGetWebMessageAsString)(ICoreWebView2WebMessageReceivedEventArgs* This, LPWSTR* webMessageAsString);
} ICoreWebView2WebMessageReceivedEventArgsVtbl;
struct ICoreWebView2WebMessageReceivedEventArgs
{
    struct ICoreWebView2WebMessageReceivedEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2WebMessageReceivedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2WebMessageReceivedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2WebMessageReceivedEventHandler* This);
    ULONG (*Release)(ICoreWebView2WebMessageReceivedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2WebMessageReceivedEventHandler* This, ICoreWebView2* sender, ICoreWebView2WebMessageReceivedEventArgs* args);
} ICoreWebView2WebMessageReceivedEventHandlerVtbl;
struct ICoreWebView2WebMessageReceivedEventHandler
{
    struct ICoreWebView2WebMessageReceivedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2WebResourceRequestVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2WebResourceRequest* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2WebResourceRequest* This);
    ULONG (*Release)(ICoreWebView2WebResourceRequest* This);
    HRESULT (*get_Uri)(ICoreWebView2WebResourceRequest* This, LPWSTR* uri);
    HRESULT (*put_Uri)(ICoreWebView2WebResourceRequest* This, LPCWSTR uri);
    HRESULT (*get_Method)(ICoreWebView2WebResourceRequest* This, LPWSTR* method);
    HRESULT (*put_Method)(ICoreWebView2WebResourceRequest* This, LPCWSTR method);
    HRESULT (*get_Content)(ICoreWebView2WebResourceRequest* This, IStream** content);
    HRESULT (*put_Content)(ICoreWebView2WebResourceRequest* This, IStream* content);
    HRESULT (*get_Headers)(ICoreWebView2WebResourceRequest* This, ICoreWebView2HttpRequestHeaders** headers);
} ICoreWebView2WebResourceRequestVtbl;
struct ICoreWebView2WebResourceRequest
{
    struct ICoreWebView2WebResourceRequestVtbl* lpVtbl;
};
typedef struct ICoreWebView2WebResourceRequestedEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2WebResourceRequestedEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2WebResourceRequestedEventArgs* This);
    ULONG (*Release)(ICoreWebView2WebResourceRequestedEventArgs* This);
    HRESULT (*get_Request)(ICoreWebView2WebResourceRequestedEventArgs* This, ICoreWebView2WebResourceRequest** request);
    HRESULT (*get_Response)(ICoreWebView2WebResourceRequestedEventArgs* This, ICoreWebView2WebResourceResponse** response);
    HRESULT (*put_Response)(ICoreWebView2WebResourceRequestedEventArgs* This, ICoreWebView2WebResourceResponse* response);
    HRESULT (*GetDeferral)(ICoreWebView2WebResourceRequestedEventArgs* This, ICoreWebView2Deferral** deferral);
    HRESULT (*get_ResourceContext)(ICoreWebView2WebResourceRequestedEventArgs* This, COREWEBVIEW2_WEB_RESOURCE_CONTEXT* context);
} ICoreWebView2WebResourceRequestedEventArgsVtbl;
struct ICoreWebView2WebResourceRequestedEventArgs
{
    struct ICoreWebView2WebResourceRequestedEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2WebResourceRequestedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2WebResourceRequestedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2WebResourceRequestedEventHandler* This);
    ULONG (*Release)(ICoreWebView2WebResourceRequestedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2WebResourceRequestedEventHandler* This, ICoreWebView2* sender, ICoreWebView2WebResourceRequestedEventArgs* args);
} ICoreWebView2WebResourceRequestedEventHandlerVtbl;
struct ICoreWebView2WebResourceRequestedEventHandler
{
    struct ICoreWebView2WebResourceRequestedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2WebResourceResponseVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2WebResourceResponse* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2WebResourceResponse* This);
    ULONG (*Release)(ICoreWebView2WebResourceResponse* This);
    HRESULT (*get_Content)(ICoreWebView2WebResourceResponse* This, IStream** content);
    HRESULT (*put_Content)(ICoreWebView2WebResourceResponse* This, IStream* content);
    HRESULT (*get_Headers)(ICoreWebView2WebResourceResponse* This, ICoreWebView2HttpResponseHeaders** headers);
    HRESULT (*get_StatusCode)(ICoreWebView2WebResourceResponse* This, int* statusCode);
    HRESULT (*put_StatusCode)(ICoreWebView2WebResourceResponse* This, int statusCode);
    HRESULT (*get_ReasonPhrase)(ICoreWebView2WebResourceResponse* This, LPWSTR* reasonPhrase);
    HRESULT (*put_ReasonPhrase)(ICoreWebView2WebResourceResponse* This, LPCWSTR reasonPhrase);
} ICoreWebView2WebResourceResponseVtbl;
struct ICoreWebView2WebResourceResponse
{
    struct ICoreWebView2WebResourceResponseVtbl* lpVtbl;
};
typedef struct ICoreWebView2WebResourceResponseReceivedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2WebResourceResponseReceivedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2WebResourceResponseReceivedEventHandler* This);
    ULONG (*Release)(ICoreWebView2WebResourceResponseReceivedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2WebResourceResponseReceivedEventHandler* This, ICoreWebView2* sender, ICoreWebView2WebResourceResponseReceivedEventArgs* args);
} ICoreWebView2WebResourceResponseReceivedEventHandlerVtbl;
struct ICoreWebView2WebResourceResponseReceivedEventHandler
{
    struct ICoreWebView2WebResourceResponseReceivedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2WebResourceResponseReceivedEventArgsVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2WebResourceResponseReceivedEventArgs* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2WebResourceResponseReceivedEventArgs* This);
    ULONG (*Release)(ICoreWebView2WebResourceResponseReceivedEventArgs* This);
    HRESULT (*get_Request)(ICoreWebView2WebResourceResponseReceivedEventArgs* This, ICoreWebView2WebResourceRequest** request);
    HRESULT (*get_Response)(ICoreWebView2WebResourceResponseReceivedEventArgs* This, ICoreWebView2WebResourceResponseView** response);
} ICoreWebView2WebResourceResponseReceivedEventArgsVtbl;
struct ICoreWebView2WebResourceResponseReceivedEventArgs
{
    struct ICoreWebView2WebResourceResponseReceivedEventArgsVtbl* lpVtbl;
};
typedef struct ICoreWebView2WebResourceResponseViewVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2WebResourceResponseView* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2WebResourceResponseView* This);
    ULONG (*Release)(ICoreWebView2WebResourceResponseView* This);
    HRESULT (*get_Headers)(ICoreWebView2WebResourceResponseView* This, ICoreWebView2HttpResponseHeaders** headers);
    HRESULT (*get_StatusCode)(ICoreWebView2WebResourceResponseView* This, int* statusCode);
    HRESULT (*get_ReasonPhrase)(ICoreWebView2WebResourceResponseView* This, LPWSTR* reasonPhrase);
    HRESULT (*GetContent)(ICoreWebView2WebResourceResponseView* This, ICoreWebView2WebResourceResponseViewGetContentCompletedHandler* handler);
} ICoreWebView2WebResourceResponseViewVtbl;
struct ICoreWebView2WebResourceResponseView
{
    struct ICoreWebView2WebResourceResponseViewVtbl* lpVtbl;
};
typedef struct ICoreWebView2WebResourceResponseViewGetContentCompletedHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2WebResourceResponseViewGetContentCompletedHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2WebResourceResponseViewGetContentCompletedHandler* This);
    ULONG (*Release)(ICoreWebView2WebResourceResponseViewGetContentCompletedHandler* This);
    HRESULT (*Invoke)(ICoreWebView2WebResourceResponseViewGetContentCompletedHandler* This, HRESULT errorCode, IStream* content);
} ICoreWebView2WebResourceResponseViewGetContentCompletedHandlerVtbl;
struct ICoreWebView2WebResourceResponseViewGetContentCompletedHandler
{
    struct ICoreWebView2WebResourceResponseViewGetContentCompletedHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2WindowCloseRequestedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2WindowCloseRequestedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2WindowCloseRequestedEventHandler* This);
    ULONG (*Release)(ICoreWebView2WindowCloseRequestedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2WindowCloseRequestedEventHandler* This, ICoreWebView2* sender, IUnknown* args);
} ICoreWebView2WindowCloseRequestedEventHandlerVtbl;
struct ICoreWebView2WindowCloseRequestedEventHandler
{
    struct ICoreWebView2WindowCloseRequestedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2WindowFeaturesVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2WindowFeatures* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2WindowFeatures* This);
    ULONG (*Release)(ICoreWebView2WindowFeatures* This);
    HRESULT (*get_HasPosition)(ICoreWebView2WindowFeatures* This, BOOL* value);
    HRESULT (*get_HasSize)(ICoreWebView2WindowFeatures* This, BOOL* value);
    HRESULT (*get_Left)(ICoreWebView2WindowFeatures* This, UINT32* value);
    HRESULT (*get_Top)(ICoreWebView2WindowFeatures* This, UINT32* value);
    HRESULT (*get_Height)(ICoreWebView2WindowFeatures* This, UINT32* value);
    HRESULT (*get_Width)(ICoreWebView2WindowFeatures* This, UINT32* value);
    HRESULT (*get_ShouldDisplayMenuBar)(ICoreWebView2WindowFeatures* This, BOOL* value);
    HRESULT (*get_ShouldDisplayStatus)(ICoreWebView2WindowFeatures* This, BOOL* value);
    HRESULT (*get_ShouldDisplayToolbar)(ICoreWebView2WindowFeatures* This, BOOL* value);
    HRESULT (*get_ShouldDisplayScrollBars)(ICoreWebView2WindowFeatures* This, BOOL* value);
} ICoreWebView2WindowFeaturesVtbl;
struct ICoreWebView2WindowFeatures
{
    struct ICoreWebView2WindowFeaturesVtbl* lpVtbl;
};
typedef struct ICoreWebView2ZoomFactorChangedEventHandlerVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2ZoomFactorChangedEventHandler* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2ZoomFactorChangedEventHandler* This);
    ULONG (*Release)(ICoreWebView2ZoomFactorChangedEventHandler* This);
    HRESULT (*Invoke)(ICoreWebView2ZoomFactorChangedEventHandler* This, ICoreWebView2Controller* sender, IUnknown* args);
} ICoreWebView2ZoomFactorChangedEventHandlerVtbl;
struct ICoreWebView2ZoomFactorChangedEventHandler
{
    struct ICoreWebView2ZoomFactorChangedEventHandlerVtbl* lpVtbl;
};
typedef struct ICoreWebView2CompositionControllerInteropVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2CompositionControllerInterop* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2CompositionControllerInterop* This);
    ULONG (*Release)(ICoreWebView2CompositionControllerInterop* This);
    HRESULT (*get_UIAProvider)(ICoreWebView2CompositionControllerInterop* This, IUnknown** provider);
    HRESULT (*get_RootVisualTarget)(ICoreWebView2CompositionControllerInterop* This, IUnknown** target);
    HRESULT (*put_RootVisualTarget)(ICoreWebView2CompositionControllerInterop* This, IUnknown* target);
} ICoreWebView2CompositionControllerInteropVtbl;
struct ICoreWebView2CompositionControllerInterop
{
    struct ICoreWebView2CompositionControllerInteropVtbl* lpVtbl;
};
typedef struct ICoreWebView2EnvironmentInteropVtbl
{
    HRESULT (*QueryInterface)(ICoreWebView2EnvironmentInterop* This, const IID* const riid, void** ppvObject);
    ULONG (*AddRef)(ICoreWebView2EnvironmentInterop* This);
    ULONG (*Release)(ICoreWebView2EnvironmentInterop* This);
    HRESULT (*GetProviderForHwnd)(ICoreWebView2EnvironmentInterop* This, HWND hwnd, IUnknown** provider);
} ICoreWebView2EnvironmentInteropVtbl;
struct ICoreWebView2EnvironmentInterop
{
    struct ICoreWebView2EnvironmentInteropVtbl* lpVtbl;
};
