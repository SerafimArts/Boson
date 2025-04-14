<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal\ValueObject\Id;

use FFI\CData;
use Serafim\Boson\Internal\Saucer\LibSaucer;

/**
 * @template-implements IntIdInterface<int>
 */
abstract readonly class RawStructPointerId extends StructPointerId
{
    final protected function __construct(int $id, CData $ptr)
    {
        parent::__construct($id, $ptr);
    }

    /**
     * Returns new {@see static} instance from given struct pointer
     *
     * @api
     */
    final public static function fromCData(LibSaucer $api, CData $handle): self
    {
        $id = self::getPointerIntValue($api, $handle);

        return new static($id, $handle);
    }
}
