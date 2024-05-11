<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Handle\Win32WindowHandle;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;

final readonly class WebView2Factory
{
    private InstallationDetector $installation;

    private WebView2 $webview2;

    public function __construct(
        ?WebView2 $webview2 = null,
    ) {
        $this->webview2 = $webview2 ?? WebView2::getInstance();
        $this->installation = new InstallationDetector();
    }

    /**
     * @param callable(ICoreWebView2Controller):void $then
     */
    public function createController(Win32WindowHandle $handle, callable $then): void
    {
        $this->createEnvironment(function (ICoreWebView2Environment $env) use ($handle, $then) {
            $status = $env->createCoreWebView2Controller(
                handle: $handle,
                then: $then,
            );

            if ($status !== 0) {
                throw new \RuntimeException('WebView controller creation failed');
            }
        });
    }

    /**
     * @param callable(ICoreWebView2Environment):void $then
     */
    public function createEnvironment(callable $then): void
    {
        $this->installation->assertIsInstalledOrFail();

        $handler = new EnvironmentCompletedHandler(function (CData $env) use ($then): int {
            $then(new ICoreWebView2Environment(
                ptr: $env,
                webview2: $this->webview2,
            ));

            return 0;
        });

        $status = $this->webview2->CreateCoreWebView2Environment(\FFI::addr(
            ptr: $handler->get($this->webview2),
        ));

        if ($status !== 0) {
            throw new \RuntimeException('WebView environment creation failed');
        }
    }
}
