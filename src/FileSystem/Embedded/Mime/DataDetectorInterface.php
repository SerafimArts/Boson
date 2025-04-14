<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem\Embedded\Mime;

interface DataDetectorInterface
{
    /**
     * @return non-empty-lowercase-string|null
     */
    public function detectByData(string $data): ?string;
}
