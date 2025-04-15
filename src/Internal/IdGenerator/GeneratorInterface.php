<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal\IdGenerator;

use Serafim\Boson\Internal\IdGenerator\Exception\IdOverflowException;

/**
 * @template-covariant TValue of array-key
 */
interface GeneratorInterface
{
    /**
     * @return TValue
     * @throws IdOverflowException occurs in case of ID creation errors
     */
    public function nextId(): mixed;
}
