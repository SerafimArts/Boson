<?php

declare(strict_types=1);

namespace Serafim\Boson;

use Serafim\Boson\Core\WebView;

final readonly class Application
{
    public WebView $webview;

    public function __construct(
        public ApplicationCreateInfo $info = new ApplicationCreateInfo(),
    ) {
        $this->webview = new WebView($this->info->webview);
    }

    public function quit(): void
    {
        $this->webview->terminate();
    }

    public function run(): void
    {
        if (\function_exists('\\sapi_windows_set_ctrl_handler')) {
            \sapi_windows_set_ctrl_handler(function () {
                $this->quit();
            });
        }

        $this->webview->run();
    }
}
