<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal\Application\DeferRunner;

final class NativeShutdownFunctionRunner implements DeferRunnerInterface
{
    public bool $isSupported = true;

    public function register(callable $callback): void
    {
        \register_shutdown_function($callback);
    }
}
