<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal\IdGenerator;

use Serafim\Boson\Internal\IdGenerator\Exception\IdNotSupportedException;

/**
 * @template-extends IntGenerator<int<0, 9223372036854775807>>
 */
final class Int64Generator extends IntGenerator
{
    public readonly int $initial;

    public readonly int $maximum;

    /**
     * @throws IdNotSupportedException in case of the current platform is not supported
     */
    public function __construct(
        OverflowBehaviour $onOverflow = OverflowBehaviour::Reset,
    ) {
        if (\PHP_INT_SIZE !== 8) {
            throw IdNotSupportedException::becauseInvalidPlatform('int64', 'int32');
        }

        $this->initial = 0;
        $this->maximum = 0x7FFF_FFFF_FFFF_FFFF;

        parent::__construct($onOverflow);
    }
}
