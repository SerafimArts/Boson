<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

use FFI\CData;
use Psr\EventDispatcher\EventDispatcherInterface;
use Serafim\Boson\Application;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Shared\RequiresDealloc;
use Serafim\Boson\Shared\Saucer\LibSaucer;
use Serafim\Boson\Shared\Saucer\SaucerPolicy;
use Serafim\Boson\Shared\Saucer\SaucerWindowEvent;
use Serafim\Boson\Vfs\VirtualFileSystem;
use Serafim\Boson\Vfs\VirtualFileSystemInterface;
use Serafim\Boson\WebView\WebView;
use Serafim\Boson\WebView\WebViewCreateInfo\FlagsListFormatter;
use Serafim\Boson\Window\Event\WindowClosed;
use Serafim\Boson\Window\Event\WindowClosing;
use Serafim\Boson\Window\Event\WindowDecorated;
use Serafim\Boson\Window\Event\WindowFocused;
use Serafim\Boson\Window\Event\WindowMaximized;
use Serafim\Boson\Window\Event\WindowMinimized;
use Serafim\Boson\Window\Event\WindowResized;
use Serafim\Boson\Window\Size\Managed\ManagedWindowMaxBounds;
use Serafim\Boson\Window\Size\Managed\ManagedWindowMinBounds;
use Serafim\Boson\Window\Size\Managed\ManagedWindowSize;
use Serafim\Boson\Window\Size\MutableSizeInterface;
use Serafim\Boson\Window\Size\SizeInterface;

final class Window implements WindowInterface
{
    private const string CALLBACKS_STRUCT = <<<'CDATA'
         struct {
             void (*onDecorated)(const saucer_handle *, bool decorated);
             void (*onMaximize)(const saucer_handle *, bool state);
             void (*onMinimize)(const saucer_handle *, bool state);
             SAUCER_POLICY (*onClosing)(const saucer_handle *);
             void (*onClosed)(const saucer_handle *);
             void (*onResize)(const saucer_handle *, int width, int height);
             void (*onFocus)(const saucer_handle *, bool focus);
         }
         CDATA;

    /**
     * See {@see WindowInterface::$id} property description.
     */
    public readonly WindowId $id;

    /**
     * See {@see WindowInterface::$fs} property description.
     */
    public readonly VirtualFileSystemInterface $fs;

    /**
     * See {@see WindowInterface::$webview} property description.
     */
    public readonly WebView $webview;

    /**
     * See {@see WindowInterface::$title} property description.
     */
    public string $title {
        get => $this->title ??= $this->getCurrentWindowTitle();
        set {
            $this->api->saucer_window_set_title($this->id->ptr, $this->title = $value);
        }
    }

    /**
     * See {@see WindowInterface::$size} property description.
     */
    public MutableSizeInterface $size {
        get => $this->size;
        set(SizeInterface $size) {
            if ($size instanceof ManagedWindowSize) {
                $this->size = $size;

                return;
            }

            $this->size->update($size->width, $size->height);
        }
    }

    /**
     * See {@see WindowInterface::$min} property description.
     */
    public MutableSizeInterface $min {
        get => $this->min;
        set(SizeInterface $size) {
            if ($size instanceof ManagedWindowMinBounds) {
                $this->min = $size;

                return;
            }

            $this->min->update($size->width, $size->height);
        }
    }

    /**
     * See {@see WindowInterface::$max} property description.
     */
    public MutableSizeInterface $max {
        get => $this->max;
        set(SizeInterface $size) {
            if ($size instanceof ManagedWindowMaxBounds) {
                $this->max = $size;

                return;
            }

            $this->max->update($size->width, $size->height);
        }
    }

    /**
     * See {@see WindowInterface::$isDarkModeEnabled} property description.
     */
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

    /**
     * See {@see WindowInterface::$isVisible} property description.
     */
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

    private readonly DelegateEventListener $events;

    public function __construct(
        /**
         * Contains shared WebView API library.
         */
        private readonly LibSaucer $api,
        /**
         * See {@see WindowInterface::$app} property description.
         */
        public readonly Application $app,
        /**
         * See {@see WindowInterface::$info} property description.
         */
        public readonly WindowCreateInfo $info,
        EventDispatcherInterface $dispatcher,
    ) {
        $this->id = $this->createWindowId($this->info);

        $this->events = new DelegateEventListener($dispatcher);
        $this->size = new ManagedWindowSize($this->api, $this->id->ptr);
        $this->min = new ManagedWindowMinBounds($this->api, $this->id->ptr);
        $this->max = new ManagedWindowMaxBounds($this->api, $this->id->ptr);
        $this->webview = new WebView($this->api, $this, $this->info->webview, $this->events);
        $this->fs = new VirtualFileSystem($this->api, $this->id);

        $this->createEventListener();

        if ($this->info->visible) {
            $this->show();
        }
    }

    private function onDecorated(CData $_, bool $decorated): void
    {
        $this->events->dispatch(new WindowDecorated($this, $decorated));
    }

    private function onMaximize(CData $_, bool $state): void
    {
        $this->events->dispatch(new WindowMaximized($this, $state));
    }

    private function onMinimize(CData $_, bool $state): void
    {
        $this->events->dispatch(new WindowMinimized($this, $state));
    }

    /**
     * @return SaucerPolicy::SAUCER_POLICY_*
     */
    private function onClosing(CData $_): int
    {
        $event = $this->events->dispatch(new WindowClosing($this));

        return $event->isCancelled
            ? SaucerPolicy::SAUCER_POLICY_BLOCK
            : SaucerPolicy::SAUCER_POLICY_ALLOW;
    }

    private function onClosed(CData $_): void
    {
        $this->events->dispatch(new WindowClosed($this));
    }

    /**
     * @param int<0, 2147483647> $width
     * @param int<0, 2147483647> $height
     */
    private function onResize(CData $_, int $width, int $height): void
    {
        $this->events->dispatch(new WindowResized($this, $width, $height));
    }

    private function onFocus(CData $_, bool $focus): void
    {
        $this->events->dispatch(new WindowFocused($this, $focus));
    }

    private function createEventListener(): void
    {
        $ptr = $this->id->ptr;

        $struct = $this->api->new(self::CALLBACKS_STRUCT);
        $struct->onDecorated = $this->onDecorated(...);
        $struct->onMaximize = $this->onMaximize(...);
        $struct->onMinimize = $this->onMinimize(...);
        $struct->onClosing = $this->onClosing(...);
        $struct->onClosed = $this->onClosed(...);
        $struct->onResize = $this->onResize(...);
        $struct->onFocus = $this->onFocus(...);

        $this->api->saucer_window_on($ptr, SaucerWindowEvent::SAUCER_WINDOW_EVENT_DECORATED, $struct->onDecorated);
        $this->api->saucer_window_on($ptr, SaucerWindowEvent::SAUCER_WINDOW_EVENT_MAXIMIZE, $struct->onMaximize);
        $this->api->saucer_window_on($ptr, SaucerWindowEvent::SAUCER_WINDOW_EVENT_MINIMIZE, $struct->onMinimize);
        $this->api->saucer_window_on($ptr, SaucerWindowEvent::SAUCER_WINDOW_EVENT_CLOSE, $struct->onClosing);
        $this->api->saucer_window_on($ptr, SaucerWindowEvent::SAUCER_WINDOW_EVENT_CLOSED, $struct->onClosed);
        $this->api->saucer_window_on($ptr, SaucerWindowEvent::SAUCER_WINDOW_EVENT_RESIZE, $struct->onResize);
        $this->api->saucer_window_on($ptr, SaucerWindowEvent::SAUCER_WINDOW_EVENT_FOCUS, $struct->onFocus);
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

            $this->api->saucer_window_set_size($handle, $info->width, $info->height);

            // Enable context menu in case of the corresponding value was passed
            // explicitly to the create info options or debug mode was enabled.
            $isContextMenuEnabled = $info->webview->isContextMenuEnabled ?? $this->app->debug;
            $this->api->saucer_webview_set_context_menu($handle, $isContextMenuEnabled);

            // Enable dev tools in case of the corresponding value was passed
            // explicitly to the create info options or debug mode was enabled.
            $isDevToolsEnabled = $info->webview->isDevToolsEnabled ?? $this->app->debug;
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
        $this->api->saucer_window_close($this->id->ptr);
    }

    public function __destruct()
    {
        $this->api->saucer_free($this->id->ptr);
    }
}
