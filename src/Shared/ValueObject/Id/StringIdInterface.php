<?php

declare(strict_types=1);

namespace Serafim\Boson\Shared\ValueObject\Id;

use Serafim\Boson\Shared\ValueObject\StringValueObjectInterface;

/**
 * Representation of all string-like identifiers.
 */
interface StringIdInterface extends
    StringValueObjectInterface,
    IdInterface {}
