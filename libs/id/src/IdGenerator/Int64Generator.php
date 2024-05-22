<?php

declare(strict_types=1);

namespace Local\Id\IdGenerator;

use Local\Id\Exception\IdNotSupportedException;
use Local\Id\IdFactory;
use Local\Id\IdFactoryInterface;

/**
 * @template-extends IntGenerator<int<0, 9223372036854775807>>
 */
final class Int64Generator extends IntGenerator
{
    /**
     * Maximal int64 value.
     *
     * @api
     */
    public const int MAX_VALUE = 0x7FFF_FFFF_FFFF_FFFF;

    /**
     * Minimal int64 value.
     *
     * @api
     */
    public const int MIN_VALUE = -0x7FFF_FFFF_FFFF_FFFF - 1;

    /**
     * @throws IdNotSupportedException If the current platform is not supported.
     */
    public function __construct(
        IdFactoryInterface $ids = new IdFactory(),
        OverflowBehaviour $onOverflow = OverflowBehaviour::RESET,
    ) {
        if (\PHP_INT_SIZE !== 8) {
            throw IdNotSupportedException::fromInvalidPlatform('int64', 'int32');
        }

        parent::__construct($ids, $onOverflow);
    }

    public function getInitialValue(): int
    {
        return 0;
    }

    public function getMaximalValue(): int
    {
        return self::MAX_VALUE;
    }
}
