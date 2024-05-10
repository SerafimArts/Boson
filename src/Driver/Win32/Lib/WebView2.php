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

typedef _Bool BOOL;
typedef long LONG;
typedef unsigned long ULONG;
typedef char CHAR;
typedef unsigned short wchar_t;
typedef wchar_t WCHAR;
typedef const CHAR *LPCSTR;
typedef const WCHAR *LPCWSTR;
typedef WCHAR *LPWSTR;
typedef LONG HRESULT;
typedef void *PVOID;
typedef PVOID HANDLE;
typedef HANDLE HWND;

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

typedef struct IStream IStream;
typedef struct ICoreWebView2 ICoreWebView2;
typedef struct ICoreWebView2WebResourceResponse ICoreWebView2WebResourceResponse;
typedef struct ICoreWebView2NewBrowserVersionAvailableEventHandler ICoreWebView2NewBrowserVersionAvailableEventHandler;
typedef struct ICoreWebView2FocusChangedEventHandler ICoreWebView2FocusChangedEventHandler;
typedef struct ICoreWebView2AcceleratorKeyPressedEventHandler ICoreWebView2AcceleratorKeyPressedEventHandler;
typedef struct ICoreWebView2MoveFocusRequestedEventHandler ICoreWebView2MoveFocusRequestedEventHandler;
typedef struct ICoreWebView2ZoomFactorChangedEventHandler ICoreWebView2ZoomFactorChangedEventHandler;

typedef struct EventRegistrationToken
{
    int64_t value;
} EventRegistrationToken;

/**
 * -----------------------------------------------------------------------------
 *  WebView Controller
 * -----------------------------------------------------------------------------
 */

typedef struct ICoreWebView2Controller ICoreWebView2Controller;

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

typedef struct ICoreWebView2CreateCoreWebView2ControllerCompletedHandler
    ICoreWebView2CreateCoreWebView2ControllerCompletedHandler;

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

typedef struct ICoreWebView2Environment ICoreWebView2Environment;

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

typedef struct ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler
    ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler;

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

HRESULT CreateCoreWebView2Environment(
    ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler* environmentCreatedHandler
);
