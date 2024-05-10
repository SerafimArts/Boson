<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Managed;

#[\Attribute(\Attribute::TARGET_METHOD)]
final readonly class ManagedFunction
{
    /**
     * @param non-empty-string|null $name
     */
    public function __construct(
        public ?string $name = null,
    ) {}
}
