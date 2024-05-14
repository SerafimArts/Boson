<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Handle;

use FFI\CData;
use Psr\EventDispatcher\EventDispatcherInterface;
use Random\Engine;
use Random\Randomizer;
use Serafim\WinUI\CreateInfo;
use Serafim\WinUI\Driver\Win32\Lib\Color;
use Serafim\WinUI\Driver\Win32\Lib\Cursor;
use Serafim\WinUI\Driver\Win32\Lib\Icon;
use Serafim\WinUI\Driver\Win32\Lib\User32;
use Serafim\WinUI\Driver\Win32\Lib\WindowClassStyle;
use Serafim\WinUI\Driver\Win32\Lib\WindowMessage;
use Serafim\WinUI\Driver\Win32\Text;
use Serafim\WinUI\Driver\Win32\Text\Converter;
use Serafim\WinUI\Event\WindowBlurEvent;
use Serafim\WinUI\Event\WindowCloseEvent;
use Serafim\WinUI\Event\WindowFocusEvent;
use Serafim\WinUI\Event\WindowHideEvent;
use Serafim\WinUI\Event\WindowMoveEvent;
use Serafim\WinUI\Event\WindowResizeEvent;
use Serafim\WinUI\Event\WindowShowEvent;
use Serafim\WinUI\Exception\WindowNotCreatableException;
use Serafim\WinUI\Memory\MemorySet;
use Serafim\WinUI\WindowInterface;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\WinUI\Driver\Win32
 */
final readonly class Win32ClassHandleFactory
{
    /**
     * @var int-mask-of<WindowClassStyle::CS_*>
     */
    private const int DEFAULT_CLASS_STYLE = WindowClassStyle::CS_HREDRAW
        | WindowClassStyle::CS_VREDRAW
        | WindowClassStyle::CS_OWNDC;

    private Converter $text;

    private User32 $user32;

    private Randomizer $randomizer;

    /**
     * @var MemorySet<Win32ClassHandle>
     */
    private MemorySet $handles;

    public function __construct(
        private EventDispatcherInterface $events,
        ?User32 $user32 = null,
        ?Converter $text = null,
        Engine $randomizer = new Engine\Mt19937(),
    ) {
        $this->text = $text ?? Text::getInstance();
        $this->user32 = $user32 ?? User32::getInstance();
        $this->randomizer = new Randomizer($randomizer);
        $this->handles = new MemorySet();
    }

    /**
     * @return non-empty-string
     */
    private function createWindowIdentifier(): string
    {
        $uuid = $this->randomizer->getBytes(16);

        $uuid[6] = $uuid[6] & "\x0F" | "\x40";
        $uuid[8] = $uuid[8] & "\x3F" | "\x80";

        $uuid = \bin2hex($uuid);

        return \vsprintf('%s-%s-%s-%s-%s', [
            \substr($uuid, 0, 8),
            \substr($uuid, 8, 4),
            \substr($uuid, 12, 4),
            \substr($uuid, 16, 4),
            \substr($uuid, 20, 12),
        ]);
    }

    /**
     * @param non-empty-string $id
     */
    private function createWindowClass(CreateInfo $info, Win32InstanceHandle $module, string $id): CData
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
        $class->lpszClassName = $this->text->wide($id, owned: false);
        $class->hbrBackground = $this->user32->GetSysColorBrush(Color::COLOR_WINDOW);

        if ($info->closable === false) {
            $class->style = WindowClassStyle::CS_NOCLOSE;
        }

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

    private function registerWindowFunction(CData $info, WindowInterface $window): CData
    {
        // @phpstan-ignore-next-line
        $info->lpfnWndProc = function (CData $hWnd, int $msg, int $wParam, int $lParam) use ($window): int {
            switch ($msg) {
                case WindowMessage::WM_CLOSE:
                    $this->events->dispatch(new WindowCloseEvent($window));
                    break;

                case WindowMessage::WM_SETFOCUS:
                case WindowMessage::WM_SHOWWINDOW:
                    $this->events->dispatch(new WindowFocusEvent($window));
                    break;

                case WindowMessage::WM_KILLFOCUS:
                    $this->events->dispatch(new WindowBlurEvent($window));
                    break;

                case WindowMessage::WM_ACTIVATE:
                    if ($wParam === 1) {
                        $this->events->dispatch(new WindowShowEvent($window));
                    } elseif ($wParam === 0) {
                        $this->events->dispatch(new WindowHideEvent($window));
                    }
                    break;

                case WindowMessage::WM_MOVE:
                    $this->events->dispatch(new WindowMoveEvent(
                        $window,
                        self::loWord($lParam),
                        self::hiWord($lParam),
                    ));
                    break;

                case WindowMessage::WM_SIZE:
                    $this->events->dispatch(new WindowResizeEvent(
                        $window,
                        self::loWord($lParam),
                        self::hiWord($lParam),
                    ));
                    break;
            }

            return $this->user32->DefWindowProcW($hWnd, $msg, $wParam, $lParam);
        };

        return $info;
    }

    private static function loWord(int $value): int
    {
        return ($value &= 0xffff) > 32767 ? $value - 65535 : $value;
    }

    /**
     * <code>
     *  (unsigned short)((unsigned long)value >> 16) & 0xffff
     * </code>
     */
    private static function hiWord(int $value): int
    {
        $value = ($value >> 16) & 0xffff;

        return $value > 32767 ? $value - 65535 : $value;
    }

    public function create(CreateInfo $info, Win32InstanceHandle $instance, WindowInterface $window): Win32ClassHandle
    {
        $id = $this->createWindowIdentifier();

        $result = new Win32ClassHandle(
            instance: $instance,
            id: $id,
            ptr: $this->registerWindowClass(
                info: $this->registerWindowFunction(
                    info: $this->createWindowClass(
                        info: $info,
                        module: $instance,
                        id: $id,
                    ),
                    window: $window,
                ),
            ),
        );

        $this->handles->create($result, function (Win32ClassHandle $handle) {
            $this->user32->UnregisterClassW(
                $handle->id,
                null,
            );
        });

        return $result;
    }
}
