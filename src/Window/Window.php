<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

use FFI\CData;
use Psr\EventDispatcher\EventDispatcherInterface;
use Serafim\Boson\Application;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\FileSystem\VirtualFileSystem;
use Serafim\Boson\FileSystem\VirtualFileSystemInterface;
use Serafim\Boson\Internal\RequiresDealloc;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Internal\Window\WindowEventHandler;
use Serafim\Boson\WebView\WebView;
use Serafim\Boson\WebView\WebViewCreateInfo\FlagsListFormatter;
use Serafim\Boson\Window\Size\Managed\ManagedWindowMaxBounds;
use Serafim\Boson\Window\Size\Managed\ManagedWindowMinBounds;
use Serafim\Boson\Window\Size\Managed\ManagedWindowSize;
use Serafim\Boson\Window\Size\MutableSizeInterface;
use Serafim\Boson\Window\Size\SizeInterface;

final class Window implements WindowInterface
{
    public readonly WindowId $id;

    public private(set) VirtualFileSystemInterface $fs;

    public readonly WebView $webview;

    public string $title {
        get => $this->title ??= $this->getCurrentWindowTitle();
        set {
            $this->api->saucer_window_set_title($this->id->ptr, $this->title = $value);
        }
    }

    public MutableSizeInterface $size {
        get => $this->size;
        /** @phpstan-ignore-next-line : PHPStan does not support properties correctly */
        set(SizeInterface $size) {
            if ($size instanceof ManagedWindowSize) {
                $this->size = $size;

                return;
            }

            $this->size->update($size->width, $size->height);
        }
    }

    public MutableSizeInterface $min {
        get => $this->min;
        /** @phpstan-ignore-next-line : PHPStan does not support properties correctly */
        set(SizeInterface $size) {
            if ($size instanceof ManagedWindowMinBounds) {
                $this->min = $size;

                return;
            }

            $this->min->update($size->width, $size->height);
        }
    }

    public MutableSizeInterface $max {
        get => $this->max;
        /** @phpstan-ignore-next-line : PHPStan does not support properties correctly */
        set(SizeInterface $size) {
            if ($size instanceof ManagedWindowMaxBounds) {
                $this->max = $size;

                return;
            }

            $this->max->update($size->width, $size->height);
        }
    }

    public bool $isDarkModeEnabled {
        get {
            return $this->isDarkModeEnabled
                ??= $this->api->saucer_webview_force_dark_mode($this->id->ptr);
        }
        set {
            $this->api->saucer_webview_set_force_dark_mode(
                $this->id->ptr,
                $this->isDarkModeEnabled = $value,
            );
        }
    }

    public bool $isVisible {
        get => $this->api->saucer_window_visible($this->id->ptr);
        set {
            if ($value) {
                $this->api->saucer_window_show($this->id->ptr);
            } else {
                $this->api->saucer_window_hide($this->id->ptr);
            }
        }
    }

    public bool $isDecorated {
        get => $this->api->saucer_window_decorations($this->id->ptr);
        set {
            $this->api->saucer_window_set_decorations($this->id->ptr, $value);
        }
    }

    public private(set) bool $isClosed = false;

    public readonly DelegateEventListener $events;

    /**
     * Contains an internal bridge between system {@see LibSaucer} events
     * and the PSR {@see Window::$events} dispatcher.
     *
     * @phpstan-ignore property.onlyWritten
     */
    private readonly WindowEventHandler $handler;

    public function __construct(
        /**
         * Contains shared WebView API library.
         */
        private readonly LibSaucer $api,
        public readonly Application $app,
        public readonly WindowCreateInfo $info,
        EventDispatcherInterface $dispatcher,
    ) {
        $this->id = $this->createWindowId($this->info);

        $this->events = new DelegateEventListener($dispatcher);
        $this->size = new ManagedWindowSize($this->api, $this->id->ptr);
        $this->min = new ManagedWindowMinBounds($this->api, $this->id->ptr);
        $this->max = new ManagedWindowMaxBounds($this->api, $this->id->ptr);
        $this->webview = new WebView($this->api, $this, $this->info->webview, $this->events);
        $this->fs = new VirtualFileSystem($this->api, $this);
        $this->handler = new WindowEventHandler($this->api, $this, $this->events);

        if ($this->info->visible) {
            $this->show();
        }
    }

    /**
     * Creates new window ID and internal handle
     */
    private function createWindowId(WindowCreateInfo $info): WindowId
    {
        return WindowId::fromHandle(
            api: $this->api,
            handle: $this->createWindowPointer($info),
        );
    }

    /**
     * Gets current (physical) window title
     */
    private function getCurrentWindowTitle(): string
    {
        $result = $this->api->saucer_window_title($this->id->ptr);

        try {
            return \FFI::string($result);
        } finally {
            \FFI::free($result);
        }
    }

    #[RequiresDealloc]
    private function createWindowPointer(WindowCreateInfo $info): CData
    {
        $preferences = $this->createPreferencesPointer($info);

        try {
            $handle = $this->api->saucer_new($preferences);

            if ($info->title !== '') {
                $this->api->saucer_window_set_title($handle, $info->title);
            }

            if ($info->darkMode !== null) {
                $this->api->saucer_webview_set_force_dark_mode($handle, $info->darkMode);
            }

            if ($info->resizable === false) {
                $this->api->saucer_window_set_resizable($handle, false);
            }

            if ($info->decorated === false) {
                $this->api->saucer_window_set_decorations($handle, false);
            }

            $this->api->saucer_window_set_size($handle, $info->width, $info->height);

            // Enable context menu in case of the corresponding value was passed
            // explicitly to the create info options or debug mode was enabled.
            $isContextMenuEnabled = $info->webview->isContextMenuEnabled ?? $this->app->isDebug;
            $this->api->saucer_webview_set_context_menu($handle, $isContextMenuEnabled);

            // Enable dev tools in case of the corresponding value was passed
            // explicitly to the create info options or debug mode was enabled.
            $isDevToolsEnabled = $info->webview->isDevToolsEnabled ?? $this->app->isDebug;
            $this->api->saucer_webview_set_dev_tools($handle, $isDevToolsEnabled);

            return $handle;
        } finally {
            $this->api->saucer_preferences_free($preferences);
        }
    }

    #[RequiresDealloc]
    private function createPreferencesPointer(WindowCreateInfo $info): CData
    {
        $preferences = $this->api->saucer_preferences_new($this->app->id->ptr);

        // Hardware acceleration is enabled by default.
        if ($info->enableHardwareAcceleration === false) {
            $this->api->saucer_preferences_set_hardware_acceleration($preferences, false);
        }

        // The "persistent cookies" feature uses storage value.
        // If this functionality is not required,
        // then storage can be omitted.
        if ($info->webview->storage === false) {
            $this->api->saucer_preferences_set_persistent_cookies($preferences, false);
        } else {
            $this->api->saucer_preferences_set_storage_path($preferences, $info->webview->storage);
        }

        // Specify additional flags using the formatter.
        foreach (FlagsListFormatter::format($info->webview->flags) as $value) {
            $this->api->saucer_preferences_add_browser_flag($preferences, $value);
        }

        // Define the "user-agent" header if it is specified.
        if ($info->webview->userAgent !== null) {
            $this->api->saucer_preferences_set_user_agent($preferences, $info->webview->userAgent);
        }

        return $preferences;
    }

    public function show(): void
    {
        $this->api->saucer_window_show($this->id->ptr);
    }

    public function hide(): void
    {
        $this->api->saucer_window_hide($this->id->ptr);
    }

    public function close(): void
    {
        $this->isClosed = true;
        $this->api->saucer_window_close($this->id->ptr);
    }

    public function __destruct()
    {
        // The filesystem dependency must be
        // destroyed BEFORE the window.
        unset($this->fs);

        $this->isClosed = true;
        $this->api->saucer_free($this->id->ptr);
    }
}
