<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Managed;

#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class ManagedStruct
{
    /**
     * @param non-empty-string|null $name
     */
    public function __construct(
        public ?string $name = null,
    ) {}
}
