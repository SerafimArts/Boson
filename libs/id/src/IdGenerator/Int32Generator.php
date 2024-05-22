<?php

declare(strict_types=1);

namespace Local\Id\IdGenerator;

use Local\Id\IdFactory;
use Local\Id\IdFactoryInterface;

/**
 * The most compatible generator with all subsystems and platforms.
 *
 * @template-extends IntGenerator<int<0, 2147483647>>
 */
final class Int32Generator extends IntGenerator
{
    /**
     * Maximal int32 value.
     *
     * @api
     */
    public const int MAX_VALUE = 0x7FFF_FFFF;

    /**
     * Minimal int32 value.
     *
     * @api
     */
    public const int MIN_VALUE = -0x7FFF_FFFF - 1;


    public function __construct(
        IdFactoryInterface $ids = new IdFactory(),
        OverflowBehaviour $onOverflow = OverflowBehaviour::RESET,
    ) {
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
