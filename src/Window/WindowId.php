<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

use FFI\CData;
use Serafim\Boson\Kernel\LibSaucer;
use Serafim\Boson\Shared\ValueObject\Id\StructPointerId;

final readonly class WindowId extends StructPointerId
{
    /**
     * Returns new {@see WindowId} instance from given
     * `saucer_handle*` struct pointer.
     *
     * @api
     */
    final public static function fromHandle(LibSaucer $api, CData $handle): self
    {
        $id = self::getPointerIntValue($api, $handle);

        return new self($id, $handle);
    }
}
