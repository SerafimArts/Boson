<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Bridge;

use Serafim\Boson\Core\WebView\WebViewError;
use Serafim\Boson\Core\WebView\WebViewHint;
use Serafim\Boson\Core\WebView\WebViewLibrary;
use Serafim\Boson\Exception\WebViewInternalException;
use Serafim\Boson\WebView\WebView;
use Serafim\Boson\Window\ExternalWindowCreateInfo;
use Serafim\Boson\Window\NewWindowCreateInfo;
use Serafim\Boson\Window\WindowCreateInfo;
use Serafim\Boson\Window\WindowInterface;
use Serafim\Boson\Window\WindowSizeHint;

final class WebViewWindow implements WindowInterface
{
    public readonly WebViewHandle $handle;

    public readonly WebView $webview;

    public string $title = '' {
        get => $this->title;
        set(string $title) {
            $result = $this->api->webview_set_title($this->handle->webview, $title);

            if ($result !== WebViewError::WEBVIEW_ERROR_OK) {
                throw WebViewInternalException::becauseErrorOccurs('setting window title', $result);
            }

            $this->title = $title;
        }
    }

    public function __construct(
        private readonly WebViewLibrary $api,
        public readonly WindowCreateInfo $info = new NewWindowCreateInfo(),
        bool $debug = false,
    ) {
        $webview = $this->api->webview_create(
            (int) $debug,
            $info instanceof ExternalWindowCreateInfo ? $info->handle : null
        );

        $this->handle = new WebViewHandle(
            webview: $webview,
            handle: $this->api->webview_get_window($webview),
        );

        $this->webview = new WebView(
            api: $this->api,
            webview: $webview,
            info: $info->webview,
        );

        if ($info instanceof NewWindowCreateInfo) {
            // Load title
            $this->title = $info->title;
            // Load window sizes if defined
            $this->resize($info->width, $info->height);
        }
    }

    public function resize(int $width, int $height, WindowSizeHint $hint = WindowSizeHint::Default): void
    {
        $result = $this->api->webview_set_size($this->handle->webview, $width, $height, match ($hint) {
            WindowSizeHint::MinBounds => WebViewHint::WEBVIEW_HINT_MIN,
            WindowSizeHint::MaxBounds => WebViewHint::WEBVIEW_HINT_MAX,
            WindowSizeHint::Fixed => WebViewHint::WEBVIEW_HINT_FIXED,
            default => WebViewHint::WEBVIEW_HINT_NONE,
        });

        if ($result !== WebViewError::WEBVIEW_ERROR_OK) {
            throw WebViewInternalException::becauseErrorOccurs('window resizing', $result);
        }
    }

    public function close(): void
    {
        $result = $this->api->webview_terminate($this->handle->webview);

        if ($result !== WebViewError::WEBVIEW_ERROR_OK) {
            throw WebViewInternalException::becauseErrorOccurs('window closing', $result);
        }
    }

    public function __destruct()
    {
        $result = $this->api->webview_destroy($this->handle->webview);

        if ($result !== WebViewError::WEBVIEW_ERROR_OK) {
            throw WebViewInternalException::becauseErrorOccurs('window destroying', $result);
        }
    }
}
