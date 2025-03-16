<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Requests\IdGenerator;

/**
 * The most compatible generator with all subsystems and platforms.
 *
 * @template-extends IntGenerator<int<0, 2147483647>>
 */
final class Int32Generator extends IntGenerator
{
    /**
     * {@inheritDoc}
     */
    public readonly int $initial;

    /**
     * {@inheritDoc}
     */
    public readonly int $maximum;

    /**
     * @param (OverflowBehaviour::*) $onOverflow
     */
    public function __construct(
        OverflowBehaviour $onOverflow = OverflowBehaviour::Reset,
    ) {
        parent::__construct($onOverflow);

        $this->initial = 0;
        $this->maximum = 0x7FFF_FFFF;
    }
}
