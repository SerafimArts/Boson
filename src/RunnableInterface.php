<?php

declare(strict_types=1);

namespace Serafim\Boson;

interface RunnableInterface
{
    public function run(): void;

    public function isRunnable(): bool;

    public function stop(): void;
}
