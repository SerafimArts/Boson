<?php

declare(strict_types=1);

namespace Serafim\Boson;

use Serafim\Boson\Core\WebView\WebViewLibrary;
use Serafim\Boson\WebView\WebView;
use Serafim\Boson\Window\Bridge\WebViewWindow;

final readonly class Application
{
    private WebViewLibrary $api;

    public WebViewWindow $window;

    public WebView $webview;

    public function __construct(
        public ApplicationCreateInfo $info = new ApplicationCreateInfo(),
    ) {
        $this->api = new WebViewLibrary($info->library);

        $this->window = new WebViewWindow(
            api: $this->api,
            info: $info->window,
            debug: $info->debug,
        );

        $this->webview = $this->window->webview;
    }

    public function quit(): void
    {
        $this->api->webview_terminate($this->window->handle->webview);
    }

    public function run(): void
    {
        if (\function_exists('\\sapi_windows_set_ctrl_handler')) {
            \sapi_windows_set_ctrl_handler(function () {
                $this->quit();
            });
        }

        $this->window->webview->run();
    }
}
