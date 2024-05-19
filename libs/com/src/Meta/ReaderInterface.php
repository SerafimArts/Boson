<?php

declare(strict_types=1);

namespace Local\Com\Meta;

interface ReaderInterface
{
    /**
     * @template T of object
     * @param class-string<T> $class
     * @return StructMetadata<T>
     */
    public function read(string $class): StructMetadata;
}
