<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\WebView;

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
    public int $major { get; }

    /**
     * @var UnsignedIntType
     */
    public int $minor { get; }

    /**
     * @var UnsignedIntType
     */
    public int $patch { get; }
}

/**
 * @internal internal class to ensure precise type inference
 */
abstract class WebViewVersionInfoType extends CData
{
    public WebViewVersionType $version { get; }

    /**
     * @var non-empty-string
     */
    public string $version_number { get; }

    /**
     * @var non-empty-string
     */
    public string $pre_release { get; }

    /**
     * @var non-empty-string
     */
    public string $build_metadata { get; }
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
