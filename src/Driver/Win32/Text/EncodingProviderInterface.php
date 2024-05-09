<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Text;

interface EncodingProviderInterface
{
    /**
     * @param non-empty-string $encoding
     */
    public function withInternalEncoding(string $encoding): self;

    /**
     * @param non-empty-string $encoding
     */
    public function withExternalEncoding(string $encoding): self;
}
