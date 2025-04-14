<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal\Application\QuitHandler;

final readonly class WindowsQuitHandler implements QuitHandlerInterface
{
    public bool $isSupported;

    public function __construct()
    {
        $this->isSupported = \PHP_OS_FAMILY === 'Windows'
            && \function_exists('\\sapi_windows_set_ctrl_handler');
    }

    public function register(callable $then): void
    {
        if (!$this->isSupported) {
            return;
        }

        \sapi_windows_set_ctrl_handler($then(...));
    }
}
