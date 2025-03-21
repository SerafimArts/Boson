<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Bridge\DarkMode;

use Serafim\Boson\Core\DesktopWindowManager\DWMLibrary;
use Serafim\Boson\Core\DesktopWindowManager\DWMWindowAttribute;
use Serafim\Boson\Window\Bridge\WebViewWindow;
use Serafim\Boson\Window\NewWindowCreateInfo;

final readonly class WindowsDarkModeDriver implements DarkModeDriverInterface
{
    private DWMLibrary $dwm;

    public function __construct(
        private WebViewWindow $window,
    ) {
        $this->dwm = new DWMLibrary();
    }

    /**
     * Forces refresh window to apply dark mode.
     *
     * Just change window height from `X` to `X-1` and `X` again
     */
    private function redraw(): void
    {
        $config = $this->window->info;

        if (!$config instanceof NewWindowCreateInfo) {
            return;
        }

        // Touched (changed) height value for redraw window
        $height = $config->height === 0 ? 1 : $config->height - 1;

        $this->window->resize($config->width, $height);
        $this->window->resize($config->width, $config->height);
    }

    private static function isPre20H1(): bool
    {
        if (\defined('\\PHP_WINDOWS_VERSION_BUILD')) {
            return \PHP_WINDOWS_VERSION_BUILD < 19041;
        }

        return false;
    }

    public function enable(bool $enable = true): void
    {
        $value = $this->dwm->new('LONG');
        // @phpstan-ignore-next-line : PHPStan does not support FFI
        $value->cdata = (int) $enable;

        $attribute = self::isPre20H1()
            ? DWMWindowAttribute::DWMWA_USE_IMMERSIVE_DARK_MODE_PRE_20H1
            : DWMWindowAttribute::DWMWA_USE_IMMERSIVE_DARK_MODE;

        $this->dwm->DwmSetWindowAttribute(
            $this->window->handle->ptr,
            $attribute,
            \FFI::addr($value),
            // @phpstan-ignore-next-line : PHPStan does not support FFI
            \FFI::sizeof($value),
        );

        $this->redraw();
    }
}
