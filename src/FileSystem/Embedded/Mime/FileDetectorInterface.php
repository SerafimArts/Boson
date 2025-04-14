<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem\Embedded\Mime;

interface FileDetectorInterface
{
    /**
     * @param non-empty-string $pathname
     *
     * @return non-empty-lowercase-string|null
     */
    public function detectByFile(string $pathname): ?string;
}
