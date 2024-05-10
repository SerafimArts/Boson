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
        'EventRegistrationToken',
        'EventRegistrationToken*',
        'EventRegistrationToken**',
        'ICoreWebView2Controller',
        'ICoreWebView2Controller*',
        'ICoreWebView2Controller**',
        'ICoreWebView2ControllerVtbl',
        'ICoreWebView2ControllerVtbl*',
        'ICoreWebView2ControllerVtbl**',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler*',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler**',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl*',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl**',
        'ICoreWebView2Environment',
        'ICoreWebView2Environment*',
        'ICoreWebView2Environment**',
        'ICoreWebView2EnvironmentVtbl',
        'ICoreWebView2EnvironmentVtbl*',
        'ICoreWebView2EnvironmentVtbl**',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler*',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler**',
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
        'ICoreWebView2' => '\PHPSTORM_META\ICoreWebView2',
        'ICoreWebView2*' => '\PHPSTORM_META\ICoreWebView2[]',
        'ICoreWebView2**' => '\PHPSTORM_META\ICoreWebView2[]',
        'ICoreWebView2**' => '\PHPSTORM_META\ICoreWebView2[][]',
        'ICoreWebView2WebResourceResponse' => '\PHPSTORM_META\ICoreWebView2WebResourceResponse',
        'ICoreWebView2WebResourceResponse*' => '\PHPSTORM_META\ICoreWebView2WebResourceResponse[]',
        'ICoreWebView2WebResourceResponse**' => '\PHPSTORM_META\ICoreWebView2WebResourceResponse[]',
        'ICoreWebView2WebResourceResponse**' => '\PHPSTORM_META\ICoreWebView2WebResourceResponse[][]',
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
        'EventRegistrationToken' => '\PHPSTORM_META\EventRegistrationToken',
        'EventRegistrationToken*' => '\PHPSTORM_META\EventRegistrationToken[]',
        'EventRegistrationToken**' => '\PHPSTORM_META\EventRegistrationToken[]',
        'EventRegistrationToken**' => '\PHPSTORM_META\EventRegistrationToken[][]',
        'ICoreWebView2Controller' => '\PHPSTORM_META\ICoreWebView2Controller',
        'ICoreWebView2Controller*' => '\PHPSTORM_META\ICoreWebView2Controller[]',
        'ICoreWebView2Controller**' => '\PHPSTORM_META\ICoreWebView2Controller[]',
        'ICoreWebView2Controller**' => '\PHPSTORM_META\ICoreWebView2Controller[][]',
        'ICoreWebView2ControllerVtbl' => '\PHPSTORM_META\ICoreWebView2ControllerVtbl',
        'ICoreWebView2ControllerVtbl*' => '\PHPSTORM_META\ICoreWebView2ControllerVtbl[]',
        'ICoreWebView2ControllerVtbl**' => '\PHPSTORM_META\ICoreWebView2ControllerVtbl[]',
        'ICoreWebView2ControllerVtbl**' => '\PHPSTORM_META\ICoreWebView2ControllerVtbl[][]',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandler',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler*' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandler[]',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandler[]',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandler[][]',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl*' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl[]',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl[]',
        'ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2ControllerCompletedHandlerVtbl[][]',
        'ICoreWebView2Environment' => '\PHPSTORM_META\ICoreWebView2Environment',
        'ICoreWebView2Environment*' => '\PHPSTORM_META\ICoreWebView2Environment[]',
        'ICoreWebView2Environment**' => '\PHPSTORM_META\ICoreWebView2Environment[]',
        'ICoreWebView2Environment**' => '\PHPSTORM_META\ICoreWebView2Environment[][]',
        'ICoreWebView2EnvironmentVtbl' => '\PHPSTORM_META\ICoreWebView2EnvironmentVtbl',
        'ICoreWebView2EnvironmentVtbl*' => '\PHPSTORM_META\ICoreWebView2EnvironmentVtbl[]',
        'ICoreWebView2EnvironmentVtbl**' => '\PHPSTORM_META\ICoreWebView2EnvironmentVtbl[]',
        'ICoreWebView2EnvironmentVtbl**' => '\PHPSTORM_META\ICoreWebView2EnvironmentVtbl[][]',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler*' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler[]',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler[]',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandler[][]',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl*' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl[]',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl[]',
        'ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl**' => '\PHPSTORM_META\ICoreWebView2CreateCoreWebView2EnvironmentCompletedHandlerVtbl[][]',
    ]));
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
     * Generated "ICoreWebView2" structure layout.
     *
     * @ignore
     * @internal Internal interface to ensure precise type inference.
     */
    final class ICoreWebView2 extends \FFI\CData
    {
        /**
         * @internal Please use {@see \Serafim\WinUI\Driver\Win32\Lib\WebView2::new()} with 'ICoreWebView2' argument instead.
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
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Environment}, null|\FFI\CData|array{\PHPSTORM_META\IStream}, int<-2147483648, 2147483647>, null|\FFI\CData|object{cdata:int<0, 65536>}, null|\FFI\CData|object{cdata:int<0, 65536>}, null|\FFI\CData|array{null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2WebResourceResponse}}):(int<-2147483648, 2147483647>)
         */
        public ?\Closure $CreateWebResourceResponse;
        /**
         * @var FFI\CData|null|callable(null|\FFI\CData|array{\PHPSTORM_META\ICoreWebView2Environment}, null|\FFI\CData|array{null|\FFI\CData|object{cdata:int<0, 65536>}}):(int<-2147483648, 2147483647>)
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