<?php

declare(strict_types=1);

namespace Serafim\Boson;

use Serafim\Boson\Dispatcher\EventListenerProviderInterface;
use Serafim\Boson\Exception\NoDefaultWindowException;
use Serafim\Boson\WebView\WebViewInterface;
use Serafim\Boson\WebView\WebViewProviderInterface;
use Serafim\Boson\Window\Manager\WindowManagerInterface;
use Serafim\Boson\Window\WindowInterface;
use Serafim\Boson\Window\WindowProviderInterface;

interface ApplicationInterface extends
    EventListenerProviderInterface,
    WindowProviderInterface,
    WebViewProviderInterface
{
    /**
     * Gets an information DTO about the application
     * with which it was created.
     */
    public ApplicationCreateInfo $info { get; }

    /**
     * Gets windows list and methods for working with windows.
     */
    public WindowManagerInterface $windows { get; }

    public WindowInterface $window {
        /**
         * @throws NoDefaultWindowException in case the default window was
         *         already closed and removed earlier
         */
        get;
    }

    public WebViewInterface $webview {
        /**
         * @throws NoDefaultWindowException in case the default window was
         *         already closed and removed earlier
         */
        get;
    }

    /**
     * Gets debug mode of an application.
     *
     * Unlike {@see ApplicationCreateInfo::$debug}, it contains a real debug
     * value, including possibly automatically derived.
     *
     * Contains {@see true} in case of debug mode is enabled
     * or {@see false} instead.
     */
    public bool $isDebug { get; }

    /**
     * Gets running state of an application.
     *
     * Contains {@see true} in case of application is running
     * or {@see false} instead.
     */
    public bool $isRunning { get; }

    /**
     * Run an application.
     *
     * Note: Blocking operation (!!!).
     */
    public function run(): void;

    /**
     * Stops an application.
     */
    public function quit(): void;
}
