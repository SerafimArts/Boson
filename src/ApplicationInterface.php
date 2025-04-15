<?php

declare(strict_types=1);

namespace Serafim\Boson;

use Serafim\Boson\Dispatcher\EventListenerInterface;
use Serafim\Boson\Exception\NoDefaultWindowException;
use Serafim\Boson\WebView\WebViewInterface;
use Serafim\Boson\Window\Manager\WindowManagerInterface;
use Serafim\Boson\Window\WindowInterface;

interface ApplicationInterface
{
    /**
     * Gets an identifier of the application.
     */
    public ApplicationId $id { get; }

    /**
     * Gets an information DTO about the application
     * with which it was created.
     */
    public ApplicationCreateInfo $info { get; }

    /**
     * Gets event listener of an application with application
     * event and intention subscriptions.
     */
    public EventListenerInterface $events { get; }

    /**
     * Gets windows list and methods for working with windows.
     */
    public WindowManagerInterface $windows { get; }

    /**
     * Gets default window instance.
     */
    public WindowInterface $window {
        /**
         * @throws NoDefaultWindowException in case the default window was
         *         already closed and removed earlier
         */
        get;
    }

    /**
     * Gets webview of the default application`s window.
     */
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
}
