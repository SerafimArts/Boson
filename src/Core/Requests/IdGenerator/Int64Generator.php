<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Requests\IdGenerator;

use Serafim\Boson\Exception\IdNotSupportedException;

/**
 * @template-extends IntGenerator<int<0, 9223372036854775807>>
 */
final class Int64Generator extends IntGenerator
{
    public readonly int $initial;

    public readonly int $maximum;

    /**
     * @throws IdNotSupportedException if the current platform is not supported
     */
    public function __construct(
        OverflowBehaviour $onOverflow = OverflowBehaviour::Reset,
    ) {
        if (\PHP_INT_SIZE !== 8) {
            throw IdNotSupportedException::becauseInvalidPlatform('int64', 'int32');
        }

        parent::__construct($onOverflow);

        $this->initial = 0;
        $this->maximum = 0x7FFF_FFFF_FFFF_FFFF;
    }
}
