<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Handle;

use FFI\CData;
use Random\Engine;
use Random\Randomizer;
use Serafim\WinUI\Driver\Win32\Lib\Color;
use Serafim\WinUI\Driver\Win32\Lib\Cursor;
use Serafim\WinUI\Driver\Win32\Lib\Icon;
use Serafim\WinUI\Driver\Win32\Lib\User32;
use Serafim\WinUI\Driver\Win32\Lib\WindowClassStyle;
use Serafim\WinUI\Driver\Win32\Text;
use Serafim\WinUI\Driver\Win32\Text\Converter;
use Serafim\WinUI\Exception\WindowNotCreatableException;
use Serafim\WinUI\Memory\DestructorCallback;
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
    private function createWindowClass(Win32InstanceHandle $module, string $id): CData
    {
        $info = $this->user32->new('WNDCLASSW');

        if ($info === null) {
            throw new \RuntimeException('Could not create window class structure');
        }

        $info->hCursor = $this->user32->LoadCursorW(null, Cursor::IDC_ARROW->toCData());
        $info->cbClsExtra = 0;
        $info->cbWndExtra = 0;
        $info->style = self::DEFAULT_CLASS_STYLE;
        $info->hIcon = $this->user32->LoadIconW(null, Icon::IDI_APPLICATION->toCData());
        $info->hInstance = $module->ptr;
        $info->lpszMenuName = null;
        $info->lpszClassName = $this->text->wide($id, owned: false);
        $info->hbrBackground = $this->user32->GetSysColorBrush(Color::COLOR_WINDOW);

        /** @var CData */
        return $info;
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
        $info->lpfnWndProc = function (CData $hWnd, int $msg, int $wParam, int $lParam): int {
            return $this->user32->DefWindowProcW($hWnd, $msg, $wParam, $lParam);
        };

        return $info;
    }

    public function create(Win32InstanceHandle $module, WindowInterface $window): Win32ClassHandle
    {
        $id = $this->createWindowIdentifier();

        $result = new Win32ClassHandle(
            instance: $module,
            id: $id,
            ptr: $this->registerWindowClass(
                info: $this->registerWindowFunction(
                    info: $this->createWindowClass(
                        module: $module,
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
