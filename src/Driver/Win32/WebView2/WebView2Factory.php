<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;

final readonly class WebView2Factory
{
    private InstallationDetector $installation;

    private WebView2 $webView2;

    public function __construct(
        ?WebView2 $webView2 = null,
    ) {
        $this->webView2 = $webView2 ?? WebView2::getInstance();
        $this->installation = new InstallationDetector();
    }

    /**
     * @param callable(ICoreWebView2Environment):void $then
     */
    public function create(callable $then): void
    {
        $this->installation->assertIsInstalledOrFail();

        $handler = new EnvironmentCompletedHandler(function (CData $env) use ($then): int {
            $then(new ICoreWebView2Environment(
                ptr: $env,
                webView2: $this->webView2,
            ));

            return 0;
        });

        $status = $this->webView2->CreateCoreWebView2Environment(\FFI::addr(
            ptr: $handler->get($this->webView2),
        ));

        if ($status !== 0) {
            throw new \RuntimeException('WebView environment creation failed');
        }
    }
}
