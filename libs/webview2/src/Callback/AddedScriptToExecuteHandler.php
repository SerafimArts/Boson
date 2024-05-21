<?php

declare(strict_types=1);

namespace Local\WebView2\Callback;

final readonly class AddedScriptToExecuteHandler
{
    /**
     * @param non-empty-string $id
     */
    public function __construct(
        public string $id,
    ) {}
}
