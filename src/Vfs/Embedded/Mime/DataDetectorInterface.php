<?php

declare(strict_types=1);

namespace Serafim\Boson\Vfs\Embedded\Mime;

interface DataDetectorInterface
{
    /**
     * @return non-empty-lowercase-string|null
     */
    public function detectByData(string $data): ?string;
}
