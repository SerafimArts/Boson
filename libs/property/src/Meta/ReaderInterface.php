<?php

declare(strict_types=1);

namespace Local\Property\Meta;

interface ReaderInterface
{
    /**
     * @param class-string $class
     * @return iterable<array-key, PropertyMetadata>
     */
    public function read(string $class): iterable;
}
