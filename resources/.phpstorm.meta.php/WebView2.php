<?php

// @formatter:off
// phpcs:ignoreFile

/**
 * A helper file for FFI, to provide autocomplete information to your IDE
 * Generated for FFI {@see Serafim\WinUI\Driver\Win32\Lib\WebView2}.
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author Nesmeyanov Kirill <nesk@xakep.ru>
 * @see https://github.com/php-ffi/ide-helper-generator
 *
 * @psalm-suppress all
 */

declare (strict_types=1);
namespace PHPSTORM_META {
    registerArgumentsSet(
        // ffi_webview2types_list
        'ffi_webview2types_list',
        'void*',
        'bool',
        'float',
        'double',
        'char',
        'int8_t',
        'uint8_t',
        'int16_t',
        'uint16_t',
        'int32_t',
        'uint32_t',
        'int64_t',
        'uint64_t',
        'BOOL',
        'LONG',
        'ULONG',
        'INT',
        'INT32',
        'UINT',
        'UINT32',
        'CHAR',
        'WCHAR',
        'LPCSTR',
        'LPCWSTR',
        'LPWSTR',
        'HRESULT',
        'PVOID',
        'HANDLE',
        'HWND',
        'GUID',
        'GUID*',
        'GUID**',
        'IID',
        'IID*',
        'IID**',
        'RECT',
        'RECT*',
        'RECT**',
        'COREWEBVIEW2_MOVE_FOCUS_REASON',
        'COREWEBVIEW2_WEB_RESOURCE_CONTEXT',
        'COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT',
        'ICoreWebView2Settings',
        'ICoreWebView2Settings*',
        'ICoreWebView2Settings**',
        'ICoreWebView2',
        'ICoreWebView2*',
        'ICoreWebView2**',
        'ICoreWebView2Controller',
        'ICoreWebView2Controller*',
        'ICoreWebView2Controller**',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler*',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler**',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler*',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler**',
        'ICoreWebView2Environment',
        'ICoreWebView2Environment*',
        'ICoreWebView2Environment**',
        'EventRegistrationToken',
        'EventRegistrationToken*',
        'EventRegistrationToken**',
        'ICoreWebView2SettingsVtbl',
        'ICoreWebView2SettingsVtbl*',
        'ICoreWebView2SettingsVtbl**',
        'ICoreWebView2Vtbl',
        'ICoreWebView2Vtbl*',
        'ICoreWebView2Vtbl**',
        'ICoreWebView2ControllerVtbl',
        'ICoreWebView2ControllerVtbl*',
        'ICoreWebView2ControllerVtbl**',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl*',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl**',
        'ICoreWebView2EnvironmentVtbl',
        'ICoreWebView2EnvironmentVtbl*',
        'ICoreWebView2EnvironmentVtbl**',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl*',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl**',
    );
    expectedArguments(\Serafim\WinUI\Driver\Win32\Lib\WebView2::new(), 0, argumentsSet('ffi_webview2types_list'));
    expectedArguments(\Serafim\WinUI\Driver\Win32\Lib\WebView2::cast(), 0, argumentsSet('ffi_webview2types_list'));
    expectedArguments(\Serafim\WinUI\Driver\Win32\Lib\WebView2::type(), 0, argumentsSet('ffi_webview2types_list'));
    override(\Serafim\WinUI\Driver\Win32\Lib\WebView2::new(0), map([
        // List of return type coercions
        '' => '\PHPSTORM_META\@',
        'VARIANT' => '\PHPSTORM_META\VARIANT',
        'VARIANT*' => '\PHPSTORM_META\VARIANT[]',
        'VARIANT**' => '\PHPSTORM_META\VARIANT[]',
        'VARIANT**' => '\PHPSTORM_META\VARIANT[][]',
        'GUID' => '\PHPSTORM_META\GUID',
        'GUID*' => '\PHPSTORM_META\GUID[]',
        'GUID**' => '\PHPSTORM_META\GUID[]',
        'GUID**' => '\PHPSTORM_META\GUID[][]',
        'IID' => '\PHPSTORM_META\IID',
        'IID*' => '\PHPSTORM_META\IID[]',
        'IID**' => '\PHPSTORM_META\IID[]',
        'IID**' => '\PHPSTORM_META\IID[][]',
        'RECT' => '\PHPSTORM_META\RECT',
        'RECT*' => '\PHPSTORM_META\RECT[]',
        'RECT**' => '\PHPSTORM_META\RECT[]',
        'RECT**' => '\PHPSTORM_META\RECT[][]',
        'IStream' => '\PHPSTORM_META\IStream',
        'IStream*' => '\PHPSTORM_META\IStream[]',
        'IStream**' => '\PHPSTORM_META\IStream[]',
        'IStream**' => '\PHPSTORM_META\IStream[][]',
        'ICoreWebView2Settings' => '\PHPSTORM_META\ICoreWebView2Settings',
        'ICoreWebView2Settings*' => '\PHPSTORM_META\ICoreWebView2Settings[]',
        'ICoreWebView2Settings**' => '\PHPSTORM_META\ICoreWebView2Settings[]',
        'ICoreWebView2Settings**' => '\PHPSTORM_META\ICoreWebView2Settings[][]',
        'ICoreWebView2' => '\PHPSTORM_META\ICoreWebView2',
        'ICoreWebView2*' => '\PHPSTORM_META\ICoreWebView2[]',
        'ICoreWebView2**' => '\PHPSTORM_META\ICoreWebView2[]',
        'ICoreWebView2**' => '\PHPSTORM_META\ICoreWebView2[][]',
        'ICoreWebView2Controller' => '\PHPSTORM_META\ICoreWebView2Controller',
        'ICoreWebView2Controller*' => '\PHPSTORM_META\ICoreWebView2Controller[]',
        'ICoreWebView2Controller**' => '\PHPSTORM_META\ICoreWebView2Controller[]',
        'ICoreWebView2Controller**' => '\PHPSTORM_META\ICoreWebView2Controller[][]',
        'ICoreWebView2WebResourceResponse' => '\PHPSTORM_META\ICoreWebView2WebResourceResponse',
        'ICoreWebView2WebResourceResponse*' => '\PHPSTORM_META\ICoreWebView2WebResourceResponse[]',
        'ICoreWebView2WebResourceResponse**' => '\PHPSTORM_META\ICoreWebView2WebResourceResponse[]',
        'ICoreWebView2WebResourceResponse**' => '\PHPSTORM_META\ICoreWebView2WebResourceResponse[][]',
        'ICoreWebView2DocumentTitleChangedEventHandler' => '\PHPSTORM_META\ICoreWebView2DocumentTitleChangedEventHandler',
        'ICoreWebView2DocumentTitleChangedEventHandler*' => '\PHPSTORM_META\ICoreWebView2DocumentTitleChangedEventHandler[]',
        'ICoreWebView2DocumentTitleChangedEventHandler**' => '\PHPSTORM_META\ICoreWebView2DocumentTitleChangedEventHandler[]',
        'ICoreWebView2DocumentTitleChangedEventHandler**' => '\PHPSTORM_META\ICoreWebView2DocumentTitleChangedEventHandler[][]',
        'ICoreWebView2NavigationStartingEventHandler' => '\PHPSTORM_META\ICoreWebView2NavigationStartingEventHandler',
        'ICoreWebView2NavigationStartingEventHandler*' => '\PHPSTORM_META\ICoreWebView2NavigationStartingEventHandler[]',
        'ICoreWebView2NavigationStartingEventHandler**' => '\PHPSTORM_META\ICoreWebView2NavigationStartingEventHandler[]',
        'ICoreWebView2NavigationStartingEventHandler**' => '\PHPSTORM_META\ICoreWebView2NavigationStartingEventHandler[][]',
        'ICoreWebView2NewBrowserVersionAvailableEventHandler' => '\PHPSTORM_META\ICoreWebView2NewBrowserVersionAvailableEventHandler',
        'ICoreWebView2NewBrowserVersionAvailableEventHandler*' => '\PHPSTORM_META\ICoreWebView2NewBrowserVersionAvailableEventHandler[]',
        'ICoreWebView2NewBrowserVersionAvailableEventHandler**' => '\PHPSTORM_META\ICoreWebView2NewBrowserVersionAvailableEventHandler[]',
        'ICoreWebView2NewBrowserVersionAvailableEventHandler**' => '\PHPSTORM_META\ICoreWebView2NewBrowserVersionAvailableEventHandler[][]',
        'ICoreWebView2FocusChangedEventHandler' => '\PHPSTORM_META\ICoreWebView2FocusChangedEventHandler',
        'ICoreWebView2FocusChangedEventHandler*' => '\PHPSTORM_META\ICoreWebView2FocusChangedEventHandler[]',
        'ICoreWebView2FocusChangedEventHandler**' => '\PHPSTORM_META\ICoreWebView2FocusChangedEventHandler[]',
        'ICoreWebView2FocusChangedEventHandler**' => '\PHPSTORM_META\ICoreWebView2FocusChangedEventHandler[][]',
        'ICoreWebView2AcceleratorKeyPressedEventHandler' => '\PHPSTORM_META\ICoreWebView2AcceleratorKeyPressedEventHandler',
        'ICoreWebView2AcceleratorKeyPressedEventHandler*' => '\PHPSTORM_META\ICoreWebView2AcceleratorKeyPressedEventHandler[]',
        'ICoreWebView2AcceleratorKeyPressedEventHandler**' => '\PHPSTORM_META\ICoreWebView2AcceleratorKeyPressedEventHandler[]',
        'ICoreWebView2AcceleratorKeyPressedEventHandler**' => '\PHPSTORM_META\ICoreWebView2AcceleratorKeyPressedEventHandler[][]',
        'ICoreWebView2MoveFocusRequestedEventHandler' => '\PHPSTORM_META\ICoreWebView2MoveFocusRequestedEventHandler',
        'ICoreWebView2MoveFocusRequestedEventHandler*' => '\PHPSTORM_META\ICoreWebView2MoveFocusRequestedEventHandler[]',
        'ICoreWebView2MoveFocusRequestedEventHandler**' => '\PHPSTORM_META\ICoreWebView2MoveFocusRequestedEventHandler[]',
        'ICoreWebView2MoveFocusRequestedEventHandler**' => '\PHPSTORM_META\ICoreWebView2MoveFocusRequestedEventHandler[][]',
        'ICoreWebView2ZoomFactorChangedEventHandler' => '\PHPSTORM_META\ICoreWebView2ZoomFactorChangedEventHandler',
        'ICoreWebView2ZoomFactorChangedEventHandler*' => '\PHPSTORM_META\ICoreWebView2ZoomFactorChangedEventHandler[]',
        'ICoreWebView2ZoomFactorChangedEventHandler**' => '\PHPSTORM_META\ICoreWebView2ZoomFactorChangedEventHandler[]',
        'ICoreWebView2ZoomFactorChangedEventHandler**' => '\PHPSTORM_META\ICoreWebView2ZoomFactorChangedEventHandler[][]',
        'ICoreWebView2WebResourceRequestedEventHandler' => '\PHPSTORM_META\ICoreWebView2WebResourceRequestedEventHandler',
        'ICoreWebView2WebResourceRequestedEventHandler*' => '\PHPSTORM_META\ICoreWebView2WebResourceRequestedEventHandler[]',
        'ICoreWebView2WebResourceRequestedEventHandler**' => '\PHPSTORM_META\ICoreWebView2WebResourceRequestedEventHandler[]',
        'ICoreWebView2WebResourceRequestedEventHandler**' => '\PHPSTORM_META\ICoreWebView2WebResourceRequestedEventHandler[][]',
        'ICoreWebView2ContainsFullScreenElementChangedEventHandler' => '\PHPSTORM_META\ICoreWebView2ContainsFullScreenElementChangedEventHandler',
        'ICoreWebView2ContainsFullScreenElementChangedEventHandler*' => '\PHPSTORM_META\ICoreWebView2ContainsFullScreenElementChangedEventHandler[]',
        'ICoreWebView2ContainsFullScreenElementChangedEventHandler**' => '\PHPSTORM_META\ICoreWebView2ContainsFullScreenElementChangedEventHandler[]',
        'ICoreWebView2ContainsFullScreenElementChangedEventHandler**' => '\PHPSTORM_META\ICoreWebView2ContainsFullScreenElementChangedEventHandler[][]',
        'ICoreWebView2NewWindowRequestedEventHandler' => '\PHPSTORM_META\ICoreWebView2NewWindowRequestedEventHandler',
        'ICoreWebView2NewWindowRequestedEventHandler*' => '\PHPSTORM_META\ICoreWebView2NewWindowRequestedEventHandler[]',
        'ICoreWebView2NewWindowRequestedEventHandler**' => '\PHPSTORM_META\ICoreWebView2NewWindowRequestedEventHandler[]',
        'ICoreWebView2NewWindowRequestedEventHandler**' => '\PHPSTORM_META\ICoreWebView2NewWindowRequestedEventHandler[][]',
        'ICoreWebView2ContentLoadingEventHandler' => '\PHPSTORM_META\ICoreWebView2ContentLoadingEventHandler',
        'ICoreWebView2ContentLoadingEventHandler*' => '\PHPSTORM_META\ICoreWebView2ContentLoadingEventHandler[]',
        'ICoreWebView2ContentLoadingEventHandler**' => '\PHPSTORM_META\ICoreWebView2ContentLoadingEventHandler[]',
        'ICoreWebView2ContentLoadingEventHandler**' => '\PHPSTORM_META\ICoreWebView2ContentLoadingEventHandler[][]',
        'ICoreWebView2SourceChangedEventHandler' => '\PHPSTORM_META\ICoreWebView2SourceChangedEventHandler',
        'ICoreWebView2SourceChangedEventHandler*' => '\PHPSTORM_META\ICoreWebView2SourceChangedEventHandler[]',
        'ICoreWebView2SourceChangedEventHandler**' => '\PHPSTORM_META\ICoreWebView2SourceChangedEventHandler[]',
        'ICoreWebView2SourceChangedEventHandler**' => '\PHPSTORM_META\ICoreWebView2SourceChangedEventHandler[][]',
        'ICoreWebView2HistoryChangedEventHandler' => '\PHPSTORM_META\ICoreWebView2HistoryChangedEventHandler',
        'ICoreWebView2HistoryChangedEventHandler*' => '\PHPSTORM_META\ICoreWebView2HistoryChangedEventHandler[]',
        'ICoreWebView2HistoryChangedEventHandler**' => '\PHPSTORM_META\ICoreWebView2HistoryChangedEventHandler[]',
        'ICoreWebView2HistoryChangedEventHandler**' => '\PHPSTORM_META\ICoreWebView2HistoryChangedEventHandler[][]',
        'ICoreWebView2NavigationCompletedEventHandler' => '\PHPSTORM_META\ICoreWebView2NavigationCompletedEventHandler',
        'ICoreWebView2NavigationCompletedEventHandler*' => '\PHPSTORM_META\ICoreWebView2NavigationCompletedEventHandler[]',
        'ICoreWebView2NavigationCompletedEventHandler**' => '\PHPSTORM_META\ICoreWebView2NavigationCompletedEventHandler[]',
        'ICoreWebView2NavigationCompletedEventHandler**' => '\PHPSTORM_META\ICoreWebView2NavigationCompletedEventHandler[][]',
        'ICoreWebView2ScriptDialogOpeningEventHandler' => '\PHPSTORM_META\ICoreWebView2ScriptDialogOpeningEventHandler',
        'ICoreWebView2ScriptDialogOpeningEventHandler*' => '\PHPSTORM_META\ICoreWebView2ScriptDialogOpeningEventHandler[]',
        'ICoreWebView2ScriptDialogOpeningEventHandler**' => '\PHPSTORM_META\ICoreWebView2ScriptDialogOpeningEventHandler[]',
        'ICoreWebView2ScriptDialogOpeningEventHandler**' => '\PHPSTORM_META\ICoreWebView2ScriptDialogOpeningEventHandler[][]',
        'ICoreWebView2PermissionRequestedEventHandler' => '\PHPSTORM_META\ICoreWebView2PermissionRequestedEventHandler',
        'ICoreWebView2PermissionRequestedEventHandler*' => '\PHPSTORM_META\ICoreWebView2PermissionRequestedEventHandler[]',
        'ICoreWebView2PermissionRequestedEventHandler**' => '\PHPSTORM_META\ICoreWebView2PermissionRequestedEventHandler[]',
        'ICoreWebView2PermissionRequestedEventHandler**' => '\PHPSTORM_META\ICoreWebView2PermissionRequestedEventHandler[][]',
        'ICoreWebView2ProcessFailedEventHandler' => '\PHPSTORM_META\ICoreWebView2ProcessFailedEventHandler',
        'ICoreWebView2ProcessFailedEventHandler*' => '\PHPSTORM_META\ICoreWebView2ProcessFailedEventHandler[]',
        'ICoreWebView2ProcessFailedEventHandler**' => '\PHPSTORM_META\ICoreWebView2ProcessFailedEventHandler[]',
        'ICoreWebView2ProcessFailedEventHandler**' => '\PHPSTORM_META\ICoreWebView2ProcessFailedEventHandler[][]',
        'ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler' => '\PHPSTORM_META\ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler',
        'ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler*' => '\PHPSTORM_META\ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler[]',
        'ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler[]',
        'ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler[][]',
        'ICoreWebView2ExecuteScriptCompletedHandler' => '\PHPSTORM_META\ICoreWebView2ExecuteScriptCompletedHandler',
        'ICoreWebView2ExecuteScriptCompletedHandler*' => '\PHPSTORM_META\ICoreWebView2ExecuteScriptCompletedHandler[]',
        'ICoreWebView2ExecuteScriptCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2ExecuteScriptCompletedHandler[]',
        'ICoreWebView2ExecuteScriptCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2ExecuteScriptCompletedHandler[][]',
        'ICoreWebView2CapturePreviewCompletedHandler' => '\PHPSTORM_META\ICoreWebView2CapturePreviewCompletedHandler',
        'ICoreWebView2CapturePreviewCompletedHandler*' => '\PHPSTORM_META\ICoreWebView2CapturePreviewCompletedHandler[]',
        'ICoreWebView2CapturePreviewCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2CapturePreviewCompletedHandler[]',
        'ICoreWebView2CapturePreviewCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2CapturePreviewCompletedHandler[][]',
        'ICoreWebView2WebMessageReceivedEventHandler' => '\PHPSTORM_META\ICoreWebView2WebMessageReceivedEventHandler',
        'ICoreWebView2WebMessageReceivedEventHandler*' => '\PHPSTORM_META\ICoreWebView2WebMessageReceivedEventHandler[]',
        'ICoreWebView2WebMessageReceivedEventHandler**' => '\PHPSTORM_META\ICoreWebView2WebMessageReceivedEventHandler[]',
        'ICoreWebView2WebMessageReceivedEventHandler**' => '\PHPSTORM_META\ICoreWebView2WebMessageReceivedEventHandler[][]',
        'ICoreWebView2CallDevToolsProtocolMethodCompletedHandler' => '\PHPSTORM_META\ICoreWebView2CallDevToolsProtocolMethodCompletedHandler',
        'ICoreWebView2CallDevToolsProtocolMethodCompletedHandler*' => '\PHPSTORM_META\ICoreWebView2CallDevToolsProtocolMethodCompletedHandler[]',
        'ICoreWebView2CallDevToolsProtocolMethodCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2CallDevToolsProtocolMethodCompletedHandler[]',
        'ICoreWebView2CallDevToolsProtocolMethodCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2CallDevToolsProtocolMethodCompletedHandler[][]',
        'ICoreWebView2DevToolsProtocolEventReceiver' => '\PHPSTORM_META\ICoreWebView2DevToolsProtocolEventReceiver',
        'ICoreWebView2DevToolsProtocolEventReceiver*' => '\PHPSTORM_META\ICoreWebView2DevToolsProtocolEventReceiver[]',
        'ICoreWebView2DevToolsProtocolEventReceiver**' => '\PHPSTORM_META\ICoreWebView2DevToolsProtocolEventReceiver[]',
        'ICoreWebView2DevToolsProtocolEventReceiver**' => '\PHPSTORM_META\ICoreWebView2DevToolsProtocolEventReceiver[][]',
        'ICoreWebView2WindowCloseRequestedEventHandler' => '\PHPSTORM_META\ICoreWebView2WindowCloseRequestedEventHandler',
        'ICoreWebView2WindowCloseRequestedEventHandler*' => '\PHPSTORM_META\ICoreWebView2WindowCloseRequestedEventHandler[]',
        'ICoreWebView2WindowCloseRequestedEventHandler**' => '\PHPSTORM_META\ICoreWebView2WindowCloseRequestedEventHandler[]',
        'ICoreWebView2WindowCloseRequestedEventHandler**' => '\PHPSTORM_META\ICoreWebView2WindowCloseRequestedEventHandler[][]',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler*' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler[]',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler[]',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler[][]',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandler',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler*' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandler[]',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandler[]',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandler[][]',
        'ICoreWebView2Environment' => '\PHPSTORM_META\ICoreWebView2Environment',
        'ICoreWebView2Environment*' => '\PHPSTORM_META\ICoreWebView2Environment[]',
        'ICoreWebView2Environment**' => '\PHPSTORM_META\ICoreWebView2Environment[]',
        'ICoreWebView2Environment**' => '\PHPSTORM_META\ICoreWebView2Environment[][]',
        'EventRegistrationToken' => '\PHPSTORM_META\EventRegistrationToken',
        'EventRegistrationToken*' => '\PHPSTORM_META\EventRegistrationToken[]',
        'EventRegistrationToken**' => '\PHPSTORM_META\EventRegistrationToken[]',
        'EventRegistrationToken**' => '\PHPSTORM_META\EventRegistrationToken[][]',
        'ICoreWebView2SettingsVtbl' => '\PHPSTORM_META\ICoreWebView2SettingsVtbl',
        'ICoreWebView2SettingsVtbl*' => '\PHPSTORM_META\ICoreWebView2SettingsVtbl[]',
        'ICoreWebView2SettingsVtbl**' => '\PHPSTORM_META\ICoreWebView2SettingsVtbl[]',
        'ICoreWebView2SettingsVtbl**' => '\PHPSTORM_META\ICoreWebView2SettingsVtbl[][]',
        'ICoreWebView2Vtbl' => '\PHPSTORM_META\ICoreWebView2Vtbl',
        'ICoreWebView2Vtbl*' => '\PHPSTORM_META\ICoreWebView2Vtbl[]',
        'ICoreWebView2Vtbl**' => '\PHPSTORM_META\ICoreWebView2Vtbl[]',
        'ICoreWebView2Vtbl**' => '\PHPSTORM_META\ICoreWebView2Vtbl[][]',
        'ICoreWebView2ControllerVtbl' => '\PHPSTORM_META\ICoreWebView2ControllerVtbl',
        'ICoreWebView2ControllerVtbl*' => '\PHPSTORM_META\ICoreWebView2ControllerVtbl[]',
        'ICoreWebView2ControllerVtbl**' => '\PHPSTORM_META\ICoreWebView2ControllerVtbl[]',
        'ICoreWebView2ControllerVtbl**' => '\PHPSTORM_META\ICoreWebView2ControllerVtbl[][]',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl*' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl[]',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl[]',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl[][]',
        'ICoreWebView2EnvironmentVtbl' => '\PHPSTORM_META\ICoreWebView2EnvironmentVtbl',
        'ICoreWebView2EnvironmentVtbl*' => '\PHPSTORM_META\ICoreWebView2EnvironmentVtbl[]',
        'ICoreWebView2EnvironmentVtbl**' => '\PHPSTORM_META\ICoreWebView2EnvironmentVtbl[]',
        'ICoreWebView2EnvironmentVtbl**' => '\PHPSTORM_META\ICoreWebView2EnvironmentVtbl[][]',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl*' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl[]',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl[]',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl[][]',
    ]));
    /**
     * Generated "VARIANT" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class VARIANT extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'VARIANT' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "GUID" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class GUID extends \FFI\CData
    {
        /**
         * @var int<0, 4294967296>
         */
        public int $Data1;
        /**
         * @var int<0, 65536>
         */
        public int $Data2;
        /**
         * @var int<0, 65536>
         */
        public int $Data3;
        /**
         * @var list<int<0, 255>>
         */
        public array $Data4;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'GUID' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "RECT" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class RECT extends \FFI\CData
    {
        /**
         * @var int<-2147483648, 2147483647>
         */
        public int $left;
        /**
         * @var int<-2147483648, 2147483647>
         */
        public int $top;
        /**
         * @var int<-2147483648, 2147483647>
         */
        public int $right;
        /**
         * @var int<-2147483648, 2147483647>
         */
        public int $bottom;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'RECT' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "IStream" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class IStream extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'IStream' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2Settings" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2Settings extends \FFI\CData
    {
        public ?\FFI\CData $lpVtbl;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2Settings' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2 extends \FFI\CData
    {
        public ?\FFI\CData $lpVtbl;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2Controller" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2Controller extends \FFI\CData
    {
        public ?\FFI\CData $lpVtbl;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2Controller' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2WebResourceResponse" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2WebResourceResponse extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2WebResourceResponse' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2DocumentTitleChangedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2DocumentTitleChangedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2DocumentTitleChangedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2NavigationStartingEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2NavigationStartingEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2NavigationStartingEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2NewBrowserVersionAvailableEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2NewBrowserVersionAvailableEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2NewBrowserVersionAvailableEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2FocusChangedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2FocusChangedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2FocusChangedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2AcceleratorKeyPressedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2AcceleratorKeyPressedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2AcceleratorKeyPressedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2MoveFocusRequestedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2MoveFocusRequestedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2MoveFocusRequestedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2ZoomFactorChangedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2ZoomFactorChangedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2ZoomFactorChangedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2WebResourceRequestedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2WebResourceRequestedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2WebResourceRequestedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2ContainsFullScreenElementChangedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2ContainsFullScreenElementChangedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2ContainsFullScreenElementChangedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2NewWindowRequestedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2NewWindowRequestedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2NewWindowRequestedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2ContentLoadingEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2ContentLoadingEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2ContentLoadingEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2SourceChangedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2SourceChangedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2SourceChangedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2HistoryChangedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2HistoryChangedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2HistoryChangedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2NavigationCompletedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2NavigationCompletedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2NavigationCompletedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2ScriptDialogOpeningEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2ScriptDialogOpeningEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2ScriptDialogOpeningEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2PermissionRequestedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2PermissionRequestedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2PermissionRequestedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2ProcessFailedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2ProcessFailedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2ProcessFailedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2ExecuteScriptCompletedHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2ExecuteScriptCompletedHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2ExecuteScriptCompletedHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2CapturePreviewCompletedHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2CapturePreviewCompletedHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2CapturePreviewCompletedHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2WebMessageReceivedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2WebMessageReceivedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2WebMessageReceivedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2CallDevToolsProtocolMethodCompletedHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2CallDevToolsProtocolMethodCompletedHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2CallDevToolsProtocolMethodCompletedHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2DevToolsProtocolEventReceiver" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2DevToolsProtocolEventReceiver extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2DevToolsProtocolEventReceiver' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2WindowCloseRequestedEventHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2WindowCloseRequestedEventHandler extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2WindowCloseRequestedEventHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler extends \FFI\CData
    {
        public ?\FFI\CData $lpVtbl;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2CreateCoreWebView2ControllerCompletedHandler" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2CreateCoreWebView2ControllerCompletedHandler extends \FFI\CData
    {
        public ?\FFI\CData $lpVtbl;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2Environment" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2Environment extends \FFI\CData
    {
        public ?\FFI\CData $lpVtbl;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2Environment' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "EventRegistrationToken" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class EventRegistrationToken extends \FFI\CData
    {
        /**
         * @var int<min, max>
         */
        public int $value;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'EventRegistrationToken' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2SettingsVtbl" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2SettingsVtbl extends \FFI\CData
    {
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, null|\FFI\CData|array{\PHPSTORM_META\GUID}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $QueryInterface;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}):(int<0, 4294967296>)
         */
        public ?\Closure $AddRef;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}):(int<0, 4294967296>)
         */
        public ?\Closure $Release;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, null|\FFI\CData|object{cdata:int<-128, 127>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_IsScriptEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, int<-128, 127>):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $put_IsScriptEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, null|\FFI\CData|object{cdata:int<-128, 127>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_IsWebMessageEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, int<-128, 127>):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $put_IsWebMessageEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, null|\FFI\CData|object{cdata:int<-128, 127>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_AreDefaultScriptDialogsEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, int<-128, 127>):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $put_AreDefaultScriptDialogsEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, null|\FFI\CData|object{cdata:int<-128, 127>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_IsStatusBarEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, int<-128, 127>):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $put_IsStatusBarEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, null|\FFI\CData|object{cdata:int<-128, 127>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_AreDevToolsEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, int<-128, 127>):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $put_AreDevToolsEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, null|\FFI\CData|object{cdata:int<-128, 127>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_AreDefaultContextMenusEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, int<-128, 127>):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $put_AreDefaultContextMenusEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, null|\FFI\CData|object{cdata:int<-128, 127>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_AreHostObjectsAllowed;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, int<-128, 127>):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $put_AreHostObjectsAllowed;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, null|\FFI\CData|object{cdata:int<-128, 127>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_IsZoomControlEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, int<-128, 127>):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $put_IsZoomControlEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, null|\FFI\CData|object{cdata:int<-128, 127>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_IsBuiltInErrorPageEnabled;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}, int<-128, 127>):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $put_IsBuiltInErrorPageEnabled;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2SettingsVtbl' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2Vtbl" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2Vtbl extends \FFI\CData
    {
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\GUID}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $QueryInterface;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}):(int<0, 4294967296>)
         */
        public ?\Closure $AddRef;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}):(int<0, 4294967296>)
         */
        public ?\Closure $Release;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Settings}}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_Settings;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_Source;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $Navigate;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $NavigateToString;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2NavigationStartingEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_NavigationStarting;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_NavigationStarting;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2ContentLoadingEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_ContentLoading;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_ContentLoading;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2SourceChangedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_SourceChanged;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_SourceChanged;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2HistoryChangedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_HistoryChanged;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_HistoryChanged;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2NavigationCompletedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_NavigationCompleted;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_NavigationCompleted;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2NavigationStartingEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_FrameNavigationStarting;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_FrameNavigationStarting;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2NavigationCompletedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_FrameNavigationCompleted;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_FrameNavigationCompleted;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2ScriptDialogOpeningEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_ScriptDialogOpening;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_ScriptDialogOpening;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2PermissionRequestedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_PermissionRequested;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_PermissionRequested;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2ProcessFailedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_ProcessFailed;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_ProcessFailed;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2AddScriptToExecuteOnDocumentCreatedCompletedHandler}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $AddScriptToExecuteOnDocumentCreated;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $RemoveScriptToExecuteOnDocumentCreated;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2ExecuteScriptCompletedHandler}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $ExecuteScript;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, int<-2147483648, 2147483647>|\Serafim\WinUI\Driver\Win32\Lib\WebView2::*, null|\FFI\CData|array{\PHPSTORM_META\IStream}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2CapturePreviewCompletedHandler}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $CapturePreview;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $Reload;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $PostWebMessageAsJson;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $PostWebMessageAsString;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2WebMessageReceivedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_WebMessageReceived;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_WebMessageReceived;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed, mixed, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2CallDevToolsProtocolMethodCompletedHandler}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $CallDevToolsProtocolMethod;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|object{cdata:int<0, 4294967296>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_BrowserProcessId;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|object{cdata:int<-128, 127>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_CanGoBack;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|object{cdata:int<-128, 127>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_CanGoForward;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $GoBack;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $GoForward;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed, null|\FFI\CData|array{null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2DevToolsProtocolEventReceiver}}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $GetDevToolsProtocolEventReceiver;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $Stop;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2NewWindowRequestedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_NewWindowRequested;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_NewWindowRequested;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2DocumentTitleChangedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_DocumentTitleChanged;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_DocumentTitleChanged;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_DocumentTitle;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed, null|\FFI\CData|array{\PHPSTORM_META\VARIANT}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $AddHostObjectToScript;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $RemoveHostObjectFromScript;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $OpenDevToolsWindow;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2ContainsFullScreenElementChangedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_ContainsFullScreenElementChanged;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_ContainsFullScreenElementChanged;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|object{cdata:int<-128, 127>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_ContainsFullScreenElement;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2WebResourceRequestedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_WebResourceRequested;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_WebResourceRequested;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed, int<-2147483648, 2147483647>|\Serafim\WinUI\Driver\Win32\Lib\WebView2::*):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $AddWebResourceRequestedFilter;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, mixed, int<-2147483648, 2147483647>|\Serafim\WinUI\Driver\Win32\Lib\WebView2::*):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $RemoveWebResourceRequestedFilter;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2WindowCloseRequestedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_WindowCloseRequested;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_WindowCloseRequested;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2Vtbl' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2ControllerVtbl" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2ControllerVtbl extends \FFI\CData
    {
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, null|\FFI\CData|array{\PHPSTORM_META\GUID}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $QueryInterface;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}):(int<0, 4294967296>)
         */
        public ?\Closure $AddRef;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}):(int<0, 4294967296>)
         */
        public ?\Closure $Release;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, null|\FFI\CData|object{cdata:int<-128, 127>}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_IsVisible;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, int<-128, 127>):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $put_IsVisible;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, null|\FFI\CData|array{\PHPSTORM_META\RECT}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_Bounds;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, \PHPSTORM_META\RECT):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $put_Bounds;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_ZoomFactor;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $put_ZoomFactor;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2ZoomFactorChangedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_ZoomFactorChanged;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_ZoomFactorChanged;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, \PHPSTORM_META\RECT, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $SetBoundsAndZoomFactor;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, int<-2147483648, 2147483647>|\Serafim\WinUI\Driver\Win32\Lib\WebView2::*):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $MoveFocus;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2MoveFocusRequestedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_MoveFocusRequested;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_MoveFocusRequested;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2FocusChangedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_GotFocus;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_GotFocus;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2FocusChangedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_LostFocus;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_LostFocus;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2AcceleratorKeyPressedEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_AcceleratorKeyPressed;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_AcceleratorKeyPressed;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_ParentWindow;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $put_ParentWindow;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $NotifyParentWindowPositionChanged;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $Close;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}, null|\FFI\CData|array{null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2}}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_CoreWebView2;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2ControllerVtbl' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl extends \FFI\CData
    {
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandler}, null|\FFI\CData|array{\PHPSTORM_META\GUID}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $QueryInterface;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandler}):(int<0, 4294967296>)
         */
        public ?\Closure $AddRef;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandler}):(int<0, 4294967296>)
         */
        public ?\Closure $Release;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandler}, int<-2147483648, 2147483647>, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Controller}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $Invoke;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2EnvironmentVtbl" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2EnvironmentVtbl extends \FFI\CData
    {
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Environment}, null|\FFI\CData|array{\PHPSTORM_META\GUID}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $QueryInterface;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Environment}):(int<0, 4294967296>)
         */
        public ?\Closure $AddRef;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Environment}):(int<0, 4294967296>)
         */
        public ?\Closure $Release;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Environment}, mixed, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandler}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $CreateCoreWebView2Controller;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Environment}, null|\FFI\CData|array{\PHPSTORM_META\IStream}, int<-2147483648, 2147483647>, mixed, mixed, null|\FFI\CData|array{null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2WebResourceResponse}}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $CreateWebResourceResponse;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Environment}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $get_BrowserVersionString;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Environment}, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2NewBrowserVersionAvailableEventHandler}, null|\FFI\CData|array{\PHPSTORM_META\EventRegistrationToken}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $add_NewBrowserVersionAvailable;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Environment}, \PHPSTORM_META\EventRegistrationToken):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $remove_NewBrowserVersionAvailable;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2EnvironmentVtbl' argument instead.
         */
        private function __construct()
        {
        }
    }
    /**
     * Generated "ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl extends \FFI\CData
    {
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler}, null|\FFI\CData|array{\PHPSTORM_META\GUID}, mixed):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $QueryInterface;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler}):(int<0, 4294967296>)
         */
        public ?\Closure $AddRef;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler}):(int<0, 4294967296>)
         */
        public ?\Closure $Release;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler}, int<-2147483648, 2147483647>, null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Environment}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $Invoke;
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl' argument instead.
         */
        private function __construct()
        {
        }
    }
    registerArgumentsSet(
        // ffi_webview2corewebview2_move_focus_reason
        'ffi_webview2corewebview2_move_focus_reason',
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_MOVE_FOCUS_REASON_PROGRAMMATIC,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_MOVE_FOCUS_REASON_NEXT,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_MOVE_FOCUS_REASON_PREVIOUS
    );
    registerArgumentsSet(
        // ffi_webview2corewebview2_web_resource_context
        'ffi_webview2corewebview2_web_resource_context',
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_ALL,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_DOCUMENT,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_STYLESHEET,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_IMAGE,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_MEDIA,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_FONT,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_SCRIPT,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_XML_HTTP_REQUEST,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_FETCH,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_TEXT_TRACK,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_EVENT_SOURCE,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_WEBSOCKET,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_MANIFEST,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_SIGNED_EXCHANGE,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_PING,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_CSP_VIOLATION_REPORT,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_WEB_RESOURCE_CONTEXT_OTHER
    );
    registerArgumentsSet(
        // ffi_webview2corewebview2_capture_preview_image_format
        'ffi_webview2corewebview2_capture_preview_image_format',
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT_PNG,
        \Serafim\WinUI\Driver\Win32\Lib\WebView2::COREWEBVIEW2_CAPTURE_PREVIEW_IMAGE_FORMAT_JPEG
    );
}
namespace Serafim\WinUI\Driver\Win32\Lib {
    interface WebView2
    {
        /**
         * @param null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler} $environmentCreatedHandler
         * @return int<-2147483648, 2147483647>
         */
        public function CreateCoreWebView2Environment(?\FFI\CData $environmentCreatedHandler): int;
    }
}