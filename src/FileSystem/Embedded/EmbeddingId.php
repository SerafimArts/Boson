<?php

declare(strict_types=1);

namespace Serafim\Boson\FileSystem\Embedded;

use FFI\CData;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Internal\ValueObject\Id\StructPointerId;

final readonly class EmbeddingId extends StructPointerId
{
    /**
     * Returns new {@see EmbeddingId} instance from given `saucer_embedded_file*`
     * struct pointer.
     *
     * @api
     */
    final public static function fromEmbeddedFileHandle(LibSaucer $api, CData $handle): self
    {
        $id = self::getPointerIntValue($api, $handle);

        return new self($id, $handle);
    }
}
