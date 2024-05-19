<?php

declare(strict_types=1);

namespace Serafim\Boson;

interface RunnableInterface
{
    /**
     * Run the process until there are no more tasks to perform.
     */
    public function run(): void;

    /**
     * Returns {@see true} in case of process is running
     * or {@see false} otherwise.
     */
    public function isRunning(): bool;

    /**
     * Instruct a running process to stop.
     */
    public function stop(): void;
}
