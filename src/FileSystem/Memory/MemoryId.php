<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem\Memory;

use FFI\CData;
use Serafim\Boson\Kernel\LibSaucer;
use Serafim\Boson\Shared\ValueObject\Id\StructPointerId;

final readonly class MemoryId extends StructPointerId
{
    /**
     * Returns new {@see MemoryId} instance from given `saucer_stash*`
     * struct pointer.
     *
     * @api
     */
    final public static function fromStashHandle(LibSaucer $api, CData $handle): self
    {
        $id = self::getPointerIntValue($api, $handle);

        return new self($id, $handle);
    }
}
