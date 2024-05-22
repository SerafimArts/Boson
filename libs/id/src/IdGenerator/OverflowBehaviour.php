<?php

declare(strict_types=1);

namespace Local\Id\IdGenerator;

enum OverflowBehaviour
{
    /**
     * In case of overflow of identifiers, reset the value to zero.
     */
    case RESET;

    /**
     * In case of overflow of a valid set of identifiers, throw an exception.
     */
    case EXCEPTION;
}
