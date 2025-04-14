<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal\ValueObject\Id;

use Serafim\Boson\Internal\ValueObject\StringValueObjectInterface;

/**
 * Representation of all string-like identifiers.
 */
interface StringIdInterface extends
    StringValueObjectInterface,
    IdInterface {}
