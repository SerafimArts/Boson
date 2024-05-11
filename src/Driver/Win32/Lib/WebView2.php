<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Lib;

use Serafim\WinUI\Driver\Library;

final class WebView2 extends Library
{
    public function __construct()
    {
        $isArm64 = \in_array(\php_uname('m'), ['arm64', 'aarch64'], true);

        parent::__construct($this->binary('win32', match (true) {
            $isArm64 => 'arm64',
            \PHP_INT_SIZE === 4 => 'x86',
            default => 'x64',
        }, 'WebView2Loader.dll'));
    }

    public static function getHeader(): string
    {
        return (string) \file_get_contents(__FILE__, offset: __COMPILER_HALT_OFFSET__);
    }
}

__halt_compiler();

typedef _Bool               BOOL;
typedef long                LONG;
typedef unsigned long       ULONG;
typedef int                 INT;
typedef signed int          INT32;
typedef unsigned int        UINT;
typedef unsigned int        UINT32;
typedef char                CHAR;
typedef char                WCHAR; // wide string fix
typedef const CHAR          *LPCSTR;
typedef const WCHAR         *LPCWSTR;
typedef WCHAR               *LPWSTR;
typedef LONG                HRESULT;
typedef void                *PVOID;
typedef PVOID               HANDLE;
typedef HANDLE              HWND;
typedef struct tagVARIANT   VARIANT;

typedef struct _GUID {
    unsigned long Data1;
    unsigned short Data2;
    unsigned short Data3;
    unsigned char Data4[8];
} GUID;

typedef GUID IID;

typedef struct tagRECT
{
    LONG left;
    LONG top;
    LONG right;
    LONG bottom;
} RECT;

typedef enum COREWEBVIEW2_MOVE_FOCUS_REASON
{
    COREWEBVIEW2_MOVE_FOCUS_REASON_PROGRAMMATIC = 0,
    COREWEBVIEW2_MOVE_FOCUS_REASON_NEXT = ( COREWEBVIEW2_MOVE_FOCUS_REASON_PROGRAMMATIC + 1 ) ,
    COREWEBVIEW2_MOVE_FOCUS_REASON_PREVIOUS = ( COREWEBVIEW2_MOVE_FOCUS_REASON_NEXT + 1 )
} COREWEBVIEW2_MOVE_FOCUS_REASON;

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

typedef enum COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT
{
    COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT_PNG = 0,
    COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT_JPEG = (COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT_PNG + 1)
} COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT;

typedef struct IStream IStream;
typedef struct ICoreWebView2Settings ICoreWebView2Settings;
typedef struct ICoreWebView2 ICoreWebView2;
typedef struct ICoreWebView2Controller ICoreWebView2Controller;
typedef struct ICoreWebView2WebResourceResponse ICoreWebView2WebResourceResponse;
typedef struct ICoreWebView2DocumentTitleChangedEventHandler ICoreWebView2DocumentTitleChangedEventHandler;
typedef struct ICoreWebView2NavigationStartingEventHandler ICoreWebView2NavigationStartingEventHandler;
typedef struct ICoreWebView2NewBrowserVersionAvailableEventHandler ICoreWebView2NewBrowserVersionAvailableEventHandler;
typedef struct ICoreWebView2FocusChangedEventHandler ICoreWebView2FocusChangedEventHandler;
typedef struct ICoreWebView2AcceleratorKeyPressedEventHandler ICoreWebView2AcceleratorKeyPressedEventHandler;
typedef struct ICoreWebView2MoveFocusRequestedEventHandler ICoreWebView2MoveFocusRequestedEventHandler;
typedef struct ICoreWebView2ZoomFactorChangedEventHandler ICoreWebView2ZoomFactorChangedEventHandler;
typedef struct ICoreWebView2WebResourceRequestedEventHandler ICoreWebView2WebResourceRequestedEventHandler;
typedef struct ICoreWebView2ContainsFullScreenElementChangedEventHandler ICoreWebView2ContainsFullScreenElementChangedEventHandler;
typedef struct ICoreWebView2NewWindowRequestedEventHandler ICoreWebView2NewWindowRequestedEventHandler;
typedef struct ICoreWebView2ContentLoadingEventHandler ICoreWebView2ContentLoadingEventHandler;
typedef struct ICoreWebView2SourceChangedEventHandler ICoreWebView2SourceChangedEventHandler;
typedef struct ICoreWebView2HistoryChangedEventHandler ICoreWebView2HistoryChangedEventHandler;
typedef struct ICoreWebView2NavigationCompletedEventHandler ICoreWebView2NavigationCompletedEventHandler;
typedef struct ICoreWebView2ScriptDialogOpeningEventHandler ICoreWebView2ScriptDialogOpeningEventHandler;
typedef struct ICoreWebView2PermissionRequestedEventHandler ICoreWebView2PermissionRequestedEventHandler;
typedef struct ICoreWebView2ProcessFailedEventHandler ICoreWebView2ProcessFailedEventHandler;
typedef struct ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler;
typedef struct ICoreWebView2ExecuteScriptCompletedHandler ICoreWebView2ExecuteScriptCompletedHandler;
typedef struct ICoreWebView2CapturePreviewCompletedHandler ICoreWebView2CapturePreviewCompletedHandler;
typedef struct ICoreWebView2WebMessageReceivedEventHandler ICoreWebView2WebMessageReceivedEventHandler;
typedef struct ICoreWebView2CallDevToolsProtocolMethodCompletedHandler ICoreWebView2CallDevToolsProtocolMethodCompletedHandler;
typedef struct ICoreWebView2DevToolsProtocolEventReceiver ICoreWebView2DevToolsProtocolEventReceiver;
typedef struct ICoreWebView2WindowCloseRequestedEventHandler ICoreWebView2WindowCloseRequestedEventHandler;
typedef struct ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler;
typedef struct ICoreWebView2CreateCoreWebView2ControllerCompletedHandler ICoreWebView2CreateCoreWebView2ControllerCompletedHandler;
typedef struct ICoreWebView2Environment ICoreWebView2Environment;

typedef struct EventRegistrationToken
{
    int64_t value;
} EventRegistrationToken;


/**
 * -----------------------------------------------------------------------------
 *  API
 * -----------------------------------------------------------------------------
 */

typedef struct ICoreWebView2SettingsVtbl
{
    HRESULT ( * QueryInterface)(ICoreWebView2Settings* This, const IID* const riid, void** ppvObject);
    ULONG ( * AddRef)(ICoreWebView2Settings* This);
    ULONG ( * Release)(ICoreWebView2Settings* This);
    HRESULT ( * get_IsScriptEnabled)(ICoreWebView2Settings* This, BOOL* isScriptEnabled);
    HRESULT ( * put_IsScriptEnabled)(ICoreWebView2Settings* This, BOOL isScriptEnabled);
    HRESULT ( * get_IsWebMessageEnabled)(ICoreWebView2Settings* This, BOOL* isWebMessageEnabled);
    HRESULT ( * put_IsWebMessageEnabled)(ICoreWebView2Settings* This, BOOL isWebMessageEnabled);
    HRESULT ( * get_AreDefaultScriptDialogsEnabled)(ICoreWebView2Settings* This, BOOL* areDefaultScriptDialogsEnabled);
    HRESULT ( * put_AreDefaultScriptDialogsEnabled)(ICoreWebView2Settings* This, BOOL areDefaultScriptDialogsEnabled);
    HRESULT ( * get_IsStatusBarEnabled)(ICoreWebView2Settings* This, BOOL* isStatusBarEnabled);
    HRESULT ( * put_IsStatusBarEnabled)(ICoreWebView2Settings* This, BOOL isStatusBarEnabled);
    HRESULT ( * get_AreDevToolsEnabled)(ICoreWebView2Settings* This, BOOL* areDevToolsEnabled);
    HRESULT ( * put_AreDevToolsEnabled)(ICoreWebView2Settings* This, BOOL areDevToolsEnabled);
    HRESULT ( * get_AreDefaultContextMenusEnabled)(ICoreWebView2Settings* This, BOOL* enabled);
    HRESULT ( * put_AreDefaultContextMenusEnabled)(ICoreWebView2Settings* This, BOOL enabled);
    HRESULT ( * get_AreHostObjectsAllowed)(ICoreWebView2Settings* This, BOOL* allowed);
    HRESULT ( * put_AreHostObjectsAllowed)(ICoreWebView2Settings* This, BOOL allowed);
    HRESULT ( * get_IsZoomControlEnabled)(ICoreWebView2Settings* This, BOOL* enabled);
    HRESULT ( * put_IsZoomControlEnabled)(ICoreWebView2Settings* This, BOOL enabled);
    HRESULT ( * get_IsBuiltInErrorPageEnabled)(ICoreWebView2Settings* This, BOOL* enabled);
    HRESULT ( * put_IsBuiltInErrorPageEnabled)(ICoreWebView2Settings* This, BOOL enabled);
} ICoreWebView2SettingsVtbl;

struct ICoreWebView2Settings
{
    const struct ICoreWebView2SettingsVtbl* lpVtbl;
};

/**
 * -----------------------------------------------------------------------------
 *  WebView
 * -----------------------------------------------------------------------------
 */

typedef struct ICoreWebView2Vtbl
{
    HRESULT ( * QueryInterface)(ICoreWebView2* This, const IID* const riid, void** ppvObject);
    ULONG ( * AddRef)(ICoreWebView2* This);
    ULONG ( * Release)(ICoreWebView2* This);
    HRESULT ( * get_Settings)(ICoreWebView2* This, ICoreWebView2Settings** settings);
    HRESULT ( * get_Source)(ICoreWebView2* This, LPWSTR* uri);
    HRESULT ( * Navigate)(ICoreWebView2* This, LPCWSTR uri);
    HRESULT ( * NavigateToString)(ICoreWebView2* This, LPCWSTR htmlContent);
    HRESULT ( * add_NavigationStarting)(ICoreWebView2* This, ICoreWebView2NavigationStartingEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_NavigationStarting)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * add_ContentLoading)(ICoreWebView2* This, ICoreWebView2ContentLoadingEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_ContentLoading)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * add_SourceChanged)(ICoreWebView2* This, ICoreWebView2SourceChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_SourceChanged)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * add_HistoryChanged)(ICoreWebView2* This, ICoreWebView2HistoryChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_HistoryChanged)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * add_NavigationCompleted)(ICoreWebView2* This, ICoreWebView2NavigationCompletedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_NavigationCompleted)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * add_FrameNavigationStarting)(ICoreWebView2* This, ICoreWebView2NavigationStartingEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_FrameNavigationStarting)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * add_FrameNavigationCompleted)(ICoreWebView2* This, ICoreWebView2NavigationCompletedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_FrameNavigationCompleted)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * add_ScriptDialogOpening)(ICoreWebView2* This, ICoreWebView2ScriptDialogOpeningEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_ScriptDialogOpening)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * add_PermissionRequested)(ICoreWebView2* This, ICoreWebView2PermissionRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_PermissionRequested)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * add_ProcessFailed)(ICoreWebView2* This, ICoreWebView2ProcessFailedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_ProcessFailed)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * AddScriptToExecuteOnDocumentCreated)(ICoreWebView2* This, LPCWSTR javaScript, ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler* handler);
    HRESULT ( * RemoveScriptToExecuteOnDocumentCreated)(ICoreWebView2* This, LPCWSTR id);
    HRESULT ( * ExecuteScript)(ICoreWebView2* This, LPCWSTR javaScript, ICoreWebView2ExecuteScriptCompletedHandler* handler);
    HRESULT ( * CapturePreview)(ICoreWebView2* This, COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT imageFormat, IStream* imageStream, ICoreWebView2CapturePreviewCompletedHandler* handler);
    HRESULT ( * Reload)(ICoreWebView2* This);
    HRESULT ( * PostWebMessageAsJson)(ICoreWebView2* This, LPCWSTR webMessageAsJson);
    HRESULT ( * PostWebMessageAsString)(ICoreWebView2* This, LPCWSTR webMessageAsString);
    HRESULT ( * add_WebMessageReceived)(ICoreWebView2* This, ICoreWebView2WebMessageReceivedEventHandler* handler, EventRegistrationToken* token);
    HRESULT ( * remove_WebMessageReceived)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * CallDevToolsProtocolMethod)(ICoreWebView2* This, LPCWSTR methodName, LPCWSTR parametersAsJson, ICoreWebView2CallDevToolsProtocolMethodCompletedHandler* handler);
    HRESULT ( * get_BrowserProcessId)(ICoreWebView2* This, UINT32* value);
    HRESULT ( * get_CanGoBack)(ICoreWebView2* This, BOOL* canGoBack);
    HRESULT ( * get_CanGoForward)(ICoreWebView2* This, BOOL* canGoForward);
    HRESULT ( * GoBack)(ICoreWebView2* This);
    HRESULT ( * GoForward)(ICoreWebView2* This);
    HRESULT ( * GetDevToolsProtocolEventReceiver)(ICoreWebView2* This, LPCWSTR eventName, ICoreWebView2DevToolsProtocolEventReceiver** receiver);
    HRESULT ( * Stop)(ICoreWebView2* This);
    HRESULT ( * add_NewWindowRequested)(ICoreWebView2* This, ICoreWebView2NewWindowRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_NewWindowRequested)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * add_DocumentTitleChanged)(ICoreWebView2* This, ICoreWebView2DocumentTitleChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_DocumentTitleChanged)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * get_DocumentTitle)(ICoreWebView2* This, LPWSTR* title);
    HRESULT ( * AddHostObjectToScript)(ICoreWebView2* This, LPCWSTR name, VARIANT* object);
    HRESULT ( * RemoveHostObjectFromScript)(ICoreWebView2* This, LPCWSTR name);
    HRESULT ( * OpenDevToolsWindow)(ICoreWebView2* This);
    HRESULT ( * add_ContainsFullScreenElementChanged)(ICoreWebView2* This, ICoreWebView2ContainsFullScreenElementChangedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_ContainsFullScreenElementChanged)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * get_ContainsFullScreenElement)(ICoreWebView2* This, BOOL* containsFullScreenElement);
    HRESULT ( * add_WebResourceRequested)(ICoreWebView2* This, ICoreWebView2WebResourceRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_WebResourceRequested)(ICoreWebView2* This, EventRegistrationToken token);
    HRESULT ( * AddWebResourceRequestedFilter)(ICoreWebView2* This, const LPCWSTR uri, const COREWEBVIEW2_WEB_RESOURCE_CONTEXT resourceContext);
    HRESULT ( * RemoveWebResourceRequestedFilter)(ICoreWebView2* This, const LPCWSTR uri, const COREWEBVIEW2_WEB_RESOURCE_CONTEXT resourceContext);
    HRESULT ( * add_WindowCloseRequested)(ICoreWebView2* This, ICoreWebView2WindowCloseRequestedEventHandler* eventHandler, EventRegistrationToken* token);
    HRESULT ( * remove_WindowCloseRequested)(ICoreWebView2* This, EventRegistrationToken token);
} ICoreWebView2Vtbl;

struct ICoreWebView2
{
    const struct ICoreWebView2Vtbl* lpVtbl;
};

/**
 * -----------------------------------------------------------------------------
 *  WebView Controller
 * -----------------------------------------------------------------------------
 */

typedef struct ICoreWebView2ControllerVtbl
{
    HRESULT ( *QueryInterface )(
        ICoreWebView2Controller * This,
        const IID *riid,
        void **ppvObject
    );

    ULONG ( *AddRef )(
        ICoreWebView2Controller * This
    );

    ULONG ( *Release )(
        ICoreWebView2Controller * This
    );

    HRESULT ( *get_IsVisible )(
        ICoreWebView2Controller * This,
        BOOL *isVisible
    );

    HRESULT ( *put_IsVisible )(
        ICoreWebView2Controller * This,
        BOOL isVisible
    );

    HRESULT ( *get_Bounds )(
        ICoreWebView2Controller * This,
        RECT *bounds
    );

    HRESULT ( *put_Bounds )(
        ICoreWebView2Controller * This,
        RECT bounds
    );

    HRESULT ( *get_ZoomFactor )(
        ICoreWebView2Controller * This,
        double *zoomFactor
    );

    HRESULT ( *put_ZoomFactor )(
        ICoreWebView2Controller * This,
        double zoomFactor
    );

    HRESULT ( *add_ZoomFactorChanged )(
        ICoreWebView2Controller * This,
        ICoreWebView2ZoomFactorChangedEventHandler *eventHandler,
        EventRegistrationToken *token
    );

    HRESULT ( *remove_ZoomFactorChanged )(
        ICoreWebView2Controller * This,
        EventRegistrationToken token
    );

    HRESULT ( *SetBoundsAndZoomFactor )(
        ICoreWebView2Controller * This,
        RECT bounds,
        double zoomFactor
    );

    HRESULT ( *MoveFocus )(
        ICoreWebView2Controller * This,
        COREWEBVIEW2_MOVE_FOCUS_REASON reason
    );

    HRESULT ( *add_MoveFocusRequested )(
        ICoreWebView2Controller * This,
        ICoreWebView2MoveFocusRequestedEventHandler *eventHandler,
        EventRegistrationToken *token
    );

    HRESULT ( *remove_MoveFocusRequested )(
        ICoreWebView2Controller * This,
        EventRegistrationToken token
    );

    HRESULT ( *add_GotFocus )(
        ICoreWebView2Controller * This,
        ICoreWebView2FocusChangedEventHandler *eventHandler,
        EventRegistrationToken *token
    );

    HRESULT ( *remove_GotFocus )(
        ICoreWebView2Controller * This,
        EventRegistrationToken token
    );

    HRESULT ( *add_LostFocus )(
        ICoreWebView2Controller * This,
        ICoreWebView2FocusChangedEventHandler *eventHandler,
        EventRegistrationToken *token
    );

    HRESULT ( *remove_LostFocus )(
        ICoreWebView2Controller * This,
        EventRegistrationToken token
    );

    HRESULT ( *add_AcceleratorKeyPressed )(
        ICoreWebView2Controller * This,
        ICoreWebView2AcceleratorKeyPressedEventHandler *eventHandler,
        EventRegistrationToken *token
    );

    HRESULT ( *remove_AcceleratorKeyPressed )(
        ICoreWebView2Controller * This,
        EventRegistrationToken token
    );

    HRESULT ( *get_ParentWindow )(
        ICoreWebView2Controller * This,
        HWND *parentWindow
    );

    HRESULT ( *put_ParentWindow )(
        ICoreWebView2Controller * This,
        HWND parentWindow
    );

    HRESULT ( *NotifyParentWindowPositionChanged )(
        ICoreWebView2Controller * This
    );

    HRESULT ( *Close )(
        ICoreWebView2Controller * This
    );

    HRESULT ( *get_CoreWebView2 )(
        ICoreWebView2Controller * This,
        ICoreWebView2 **coreWebView2
    );
} ICoreWebView2ControllerVtbl;

struct ICoreWebView2Controller
{
    const struct ICoreWebView2ControllerVtbl *lpVtbl;
};


/**
 * -----------------------------------------------------------------------------
 *  Create Controller Handler
 * -----------------------------------------------------------------------------
 */

typedef struct ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl
{
    HRESULT ( *QueryInterface )(
        ICoreWebView2CreateCoreWebView2ControllerCompletedHandler * This,
        const IID *riid,
        void **ppvObject
    );

    ULONG ( *AddRef )(
        ICoreWebView2CreateCoreWebView2ControllerCompletedHandler * This
    );

    ULONG ( *Release )(
        ICoreWebView2CreateCoreWebView2ControllerCompletedHandler * This
    );

    HRESULT ( *Invoke )(
        ICoreWebView2CreateCoreWebView2ControllerCompletedHandler * This,
        HRESULT errorCode,
        ICoreWebView2Controller *createdController
    );
} ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl;

struct ICoreWebView2CreateCoreWebView2ControllerCompletedHandler
{
    const struct ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl *lpVtbl;
};


/**
 * -----------------------------------------------------------------------------
 *  WebView Environment
 * -----------------------------------------------------------------------------
 */

typedef struct ICoreWebView2EnvironmentVtbl
{
    HRESULT ( *QueryInterface )(
        ICoreWebView2Environment * This,
        const IID *riid,
        void **ppvObject
    );

    ULONG ( *AddRef )(
        ICoreWebView2Environment * This
    );

    ULONG ( *Release )(
        ICoreWebView2Environment * This
    );

    HRESULT ( *CreateCoreWebView2Controller )(
        ICoreWebView2Environment * This,
        HWND parentWindow,
        ICoreWebView2CreateCoreWebView2ControllerCompletedHandler *handler
    );

    HRESULT ( *CreateWebResourceResponse )(
        ICoreWebView2Environment * This,
        IStream *content,
        int statusCode,
        LPCWSTR reasonPhrase,
        LPCWSTR headers,
        ICoreWebView2WebResourceResponse **response
    );

    HRESULT ( *get_BrowserVersionString )(
        ICoreWebView2Environment * This,
        LPWSTR *versionInfo
    );

    HRESULT ( *add_NewBrowserVersionAvailable )(
        ICoreWebView2Environment * This,
        ICoreWebView2NewBrowserVersionAvailableEventHandler *eventHandler,
        EventRegistrationToken *token
    );

    HRESULT ( *remove_NewBrowserVersionAvailable )(
        ICoreWebView2Environment * This,
        EventRegistrationToken token
    );
} ICoreWebView2EnvironmentVtbl;

struct ICoreWebView2Environment
{
    const struct ICoreWebView2EnvironmentVtbl *lpVtbl;
};

/**
 * -----------------------------------------------------------------------------
 *  Create Environment Handler
 * -----------------------------------------------------------------------------
 */

typedef struct ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl
{
    HRESULT ( *QueryInterface )(
        ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler * This,
        const IID *riid,
        void **ppvObject
    );

    ULONG ( *AddRef )(
        ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler * This
    );

    ULONG ( *Release )(
        ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler * This
    );

    HRESULT ( *Invoke )(
        ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler * This,
        HRESULT errorCode,
        ICoreWebView2Environment *createdEnvironment
    );
} ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl;

struct ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler
{
    const struct ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl *lpVtbl;
};

/**
 * -----------------------------------------------------------------------------
 *  API
 * -----------------------------------------------------------------------------
 */

HRESULT CreateCoreWebView2Environment(
    ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler* environmentCreatedHandler
);
