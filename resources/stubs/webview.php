<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\WebView {

    use FFI\CData;

    /**
     * @phpstan-type UnsignedIntType int<0, 4294967295>
     *
     * @internal internal class to ensure precise type inference
     */
    abstract class WebViewVersionType extends CData
    {
        /**
         * @var UnsignedIntType
         */
        public int $major {
            get;
        }

        /**
         * @var UnsignedIntType
         */
        public int $minor {
            get;
        }

        /**
         * @var UnsignedIntType
         */
        public int $patch {
            get;
        }
    }

    /**
     * @internal internal class to ensure precise type inference
     */
    abstract class WebViewVersionInfoType extends CData
    {
        public WebViewVersionType $version {
            get;
        }

        /**
         * @var non-empty-string
         */
        public string $version_number {
            get;
        }

        /**
         * @var non-empty-string
         */
        public string $pre_release {
            get;
        }

        /**
         * @var non-empty-string
         */
        public string $build_metadata {
            get;
        }
    }

    /**
     * @phpstan-type WebViewType CData
     * @phpstan-type WebViewErrorType WebViewError::WEBVIEW_ERROR_*
     * @phpstan-type WebViewHintType WebViewHint::WEBVIEW_HINT_*
     * @phpstan-type WebViewNativeHandleKindType WebViewNativeHandleKind::WEBVIEW_NATIVE_HANDLE_KIND_*
     * @phpstan-type UnsignedIntType int<0, 4294967295>
     * @phpstan-type SignedIntType int<-2147483648, 2147483647>
     *
     * @phpstan-type WebViewDispatchCallback callable(WebViewType $w, mixed $arg=):void
     * @phpstan-type WebViewBindCallback callable(non-empty-string $id, string $req, mixed $arg=):void
     */
    class WebViewLibrary
    {
        /**
         * @return WebViewType
         */
        public function webview_create(int $debug, mixed $window): CData {}

        /**
         * @param WebViewType $w
         * @return WebViewErrorType
         */
        public function webview_destroy(CData $w): int {}

        /**
         * @param WebViewType $w
         * @return WebViewErrorType
         */
        public function webview_run(CData $w): int {}

        /**
         * @param WebViewType $w
         * @return WebViewErrorType
         */
        public function webview_terminate(CData $w): int {}

        /**
         * @param WebViewType $w
         * @param WebViewDispatchCallback $cb
         * @return WebViewErrorType
         */
        public function webview_dispatch(CData $w, callable $cb, mixed $arg): int {}

        /**
         * @param WebViewType $w
         */
        public function webview_get_window(CData $w): CData {}

        /**
         * @param WebViewType $w
         * @param WebViewNativeHandleKindType $kind
         */
        public function webview_get_native_handle(CData $w, int $kind): CData {}

        /**
         * @param WebViewType $w
         * @return WebViewErrorType
         */
        public function webview_set_title(CData $w, string $title): int {}

        /**
         * @param WebViewType $w
         * @param SignedIntType $width
         * @param SignedIntType $height
         * @param WebViewHintType $hints
         * @return WebViewErrorType
         */
        public function webview_set_size(CData $w, int $width, int $height, int $hints): int {}

        /**
         * @param WebViewType $w
         * @return WebViewErrorType
         */
        public function webview_navigate(CData $w, string $url): int {}

        /**
         * @param WebViewType $w
         * @return WebViewErrorType
         */
        public function webview_set_html(CData $w, string $html): int {}

        /**
         * @param WebViewType $w
         * @return WebViewErrorType
         */
        public function webview_init(CData $w, string $js): int {}

        /**
         * @param WebViewType $w
         * @return WebViewErrorType
         */
        public function webview_eval(CData $w, string $js): int {}

        /**
         * @param WebViewType $w
         * @param WebViewBindCallback $cb
         * @return WebViewErrorType
         */
        public function webview_bind(CData $w, string $name, callable $cb, mixed $arg): int {}

        /**
         * @param WebViewType $w
         * @return WebViewErrorType
         */
        public function webview_unbind(CData $w, string $name): int {}

        /**
         * @param WebViewType $w
         * @return WebViewErrorType
         */
        public function webview_return(CData $w, string $name, int $status, string $result): int {}

        public function webview_version(): WebViewVersionInfoType {}

        /**
         * @param non-empty-string $library
         */
        public function __construct(string $library) {}
    }
}

namespace Serafim\Boson\Core\DesktopWindowManager {

    use FFI\CData;

    final readonly class DWMWindowAttribute
    {
        public const int DWMWA_NCRENDERING_ENABLED = 1;
        public const int DWMWA_NCRENDERING_POLICY = 2;
        public const int DWMWA_TRANSITIONS_FORCEDISABLED = 3;
        public const int DWMWA_ALLOW_NCPAINT = 4;
        public const int DWMWA_CAPTION_BUTTON_BOUNDS = 5;
        public const int DWMWA_NONCLIENT_RTL_LAYOUT = 6;
        public const int DWMWA_FORCE_ICONIC_REPRESENTATION = 7;
        public const int DWMWA_FLIP3D_POLICY = 8;
        public const int DWMWA_EXTENDED_FRAME_BOUNDS = 9;
        public const int DWMWA_HAS_ICONIC_BITMAP = 10;
        public const int DWMWA_DISALLOW_PEEK = 11;
        public const int DWMWA_EXCLUDED_FROM_PEEK = 12;
        public const int DWMWA_CLOAK = 13;
        public const int DWMWA_CLOAKED = 14;
        public const int DWMWA_FREEZE_REPRESENTATION = 15;
        public const int DWMWA_PASSIVE_UPDATE_MODE = 16;
        public const int DWMWA_USE_HOSTBACKDROPBRUSH = 17;
        public const int DWMWA_USE_IMMERSIVE_DARK_MODE_PRE_20H1 = 19;
        public const int DWMWA_USE_IMMERSIVE_DARK_MODE = 20;
        public const int DWMWA_WINDOW_CORNER_PREFERENCE = 33;
        public const int DWMWA_BORDER_COLOR = 34;
        public const int DWMWA_CAPTION_COLOR = 35;
        public const int DWMWA_TEXT_COLOR = 36;
        public const int DWMWA_VISIBLE_FRAME_BORDER_THICKNESS = 37;
        public const int DWMWA_SYSTEMBACKDROP_TYPE = 38;
        public const int DWMWA_LAST = 39;

        private function __construct() {}
    }

    /**
     * @phpstan-type HResultType int<-2147483648, 2147483647>
     * @phpstan-type WindowHandleType CData
     */
    final readonly class DWMLibrary
    {
        /**
         * @param WindowHandleType $hwnd
         * @param DWMWindowAttribute::DWMWA_*|int<0, 4294967295> $dwAttribute
         * @param int<0, 4294967295> $cbAttribute
         * @return HResultType
         */
        public function DwmSetWindowAttribute(
            CData $hwnd,
            int $dwAttribute,
            mixed $pvAttribute,
            int $cbAttribute,
        ): int {}

        /**
         * @param non-empty-string $type
         */
        public function new(string $type): CData {}
    }
}
