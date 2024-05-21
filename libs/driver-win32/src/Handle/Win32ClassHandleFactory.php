<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Handle;

use FFI\CData;
use Local\Com\WideString;
use Local\Driver\Win32\Lib\Color;
use Local\Driver\Win32\Lib\Cursor;
use Local\Driver\Win32\Lib\Icon;
use Local\Driver\Win32\Lib\User32;
use Local\Driver\Win32\Lib\WindowClassStyle;
use Local\Driver\Win32\Lib\WindowMessage;
use Local\Driver\Win32\Win32Window;
use Psr\EventDispatcher\EventDispatcherInterface;
use Serafim\Boson\Event\Window\WindowFocusLostEvent;
use Serafim\Boson\Event\Window\WindowClosedEvent;
use Serafim\Boson\Event\Window\WindowFocusReceivedEvent;
use Serafim\Boson\Event\Window\WindowHiddenEvent;
use Serafim\Boson\Event\Window\WindowMovedEvent;
use Serafim\Boson\Event\Window\WindowResizeEvent;
use Serafim\Boson\Event\Window\WindowShownEvent;
use Serafim\Boson\Exception\WindowNotCreatableException;
use Serafim\Boson\Window\CreateInfo;
use Serafim\Boson\WindowInterface;

/**
 * @internal this is an internal library class, please do not use it in your code
 */
final class Win32ClassHandleFactory
{
    /**
     * @var int-mask-of<WindowClassStyle::CS_*>
     */
    private const int DEFAULT_CLASS_STYLE = WindowClassStyle::CS_HREDRAW
        | WindowClassStyle::CS_VREDRAW
        | WindowClassStyle::CS_OWNDC;

    private ?Win32ClassHandle $current = null;

    /**
     * @var \ArrayObject<mixed, Win32Window>
     */
    private readonly \ArrayObject $windows;

    /**
     * @param \ArrayObject<int, Win32Window> $windows
     */
    public function __construct(
        private readonly EventDispatcherInterface $events,
        private readonly User32 $user32,
    ) {
        $this->windows = new \ArrayObject();
    }

    public function attach(Win32Window $window): void
    {
        $this->windows[$window->handle->ptr] = $window;
    }

    public function detach(Win32Window $window): void
    {
        unset($this->windows[$window->handle->ptr]);
    }

    private function createWindowClass(CreateInfo $info, Win32InstanceHandle $module): CData
    {
        $class = $this->user32->new('WNDCLASSW');

        if ($class === null) {
            throw new \RuntimeException('Could not create window class structure');
        }

        $class->hCursor = $this->user32->LoadCursorW(null, Cursor::IDC_ARROW->toCData());
        $class->cbClsExtra = 0;
        $class->cbWndExtra = 0;
        $class->style = self::DEFAULT_CLASS_STYLE;
        $class->hIcon = $this->user32->LoadIconW(null, Icon::IDI_APPLICATION->toCData());
        $class->hInstance = $module->ptr;
        $class->lpszMenuName = null;
        $class->lpszClassName = WideString::toWideStringCData($this->user32, __CLASS__);
        $class->hbrBackground = $this->user32->GetSysColorBrush(Color::COLOR_WINDOW);

        /** @var CData */
        return $class;
    }

    private function registerWindowClass(CData $info): CData
    {
        if (!$this->user32->RegisterClassW(\FFI::addr($info))) {
            throw new WindowNotCreatableException('Could not initialize window class');
        }

        return $info;
    }

    private function registerWindowFunction(CData $info): CData
    {
        // @phpstan-ignore-next-line
        $info->lpfnWndProc = function (mixed $hWnd, int $msg, int $wParam, int $lParam): int {
            $window = $this->windows[$hWnd] ?? null;

            if ($window !== null) {
                $result = $this->processWindow($window, $msg, $wParam, $lParam);

                if ($result !== null) {
                    return $result;
                }
            }

            return $this->user32->DefWindowProcW($hWnd, $msg, $wParam, $lParam);
        };

        return $info;
    }

    private function processWindow(WindowInterface $window, int $msg, int $wParam, int $lParam): ?int
    {
        switch ($msg) {
            case WindowMessage::WM_CLOSE:
                $this->events->dispatch(new WindowClosedEvent($window));
                return 0;

            case WindowMessage::WM_SETFOCUS:
                $this->events->dispatch(new WindowFocusReceivedEvent($window));
                return 0;

            case WindowMessage::WM_KILLFOCUS:
                $this->events->dispatch(new WindowFocusLostEvent($window));
                return 0;

            case WindowMessage::WM_MOVE:
                $this->events->dispatch(new WindowMovedEvent(
                    $window,
                    self::loWord($lParam),
                    self::hiWord($lParam),
                ));
                return 0;

            case WindowMessage::WM_ACTIVATE:
                if ($wParam !== 1) {
                    $this->events->dispatch(new WindowHiddenEvent($window));
                } else {
                    $this->events->dispatch(new WindowShownEvent($window));
                }
                return 0;

            case WindowMessage::WM_CAPTURECHANGED:
                // change full size/normal states
                //echo sprintf("[%08d] %s\n", $msg, WindowMessage::get($msg));
                return 0;

            case WindowMessage::WM_SIZE:
                $this->events->dispatch(new WindowResizeEvent(
                    $window,
                    \max(0, self::loWord($lParam)),
                    \max(0, self::hiWord($lParam)),
                ));
                return 0;
        }

        return null;
    }

    private static function loWord(int $value): int
    {
        return ($value &= 0xffff) > 32767 ? $value - 65535 : $value;
    }

    /**
     * ```
     *  (unsigned short)((unsigned long)value >> 16) & 0xffff
     * ```
     */
    private static function hiWord(int $value): int
    {
        $value = ($value >> 16) & 0xffff;

        return $value > 32767 ? $value - 65535 : $value;
    }

    public function create(CreateInfo $info, Win32InstanceHandle $instance): Win32ClassHandle
    {
        return $this->current ??= new Win32ClassHandle(
            instance: $instance,
            id: __CLASS__,
            ptr: $this->registerWindowClass(
                info: $this->registerWindowFunction(
                    info: $this->createWindowClass(
                        info: $info,
                        module: $instance,
                    ),
                ),
            ),
        );
    }

    public function __destruct()
    {
        if ($this->current === null) {
            return;
        }

        $this->user32->UnregisterClassW($this->current->id, null);
    }
}
