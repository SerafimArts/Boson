<?php

declare(strict_types=1);

namespace Serafim\Boson\Shared\IdValueGenerator;

use Serafim\Boson\Shared\IdValueGenerator\Exception\IdOverflowException;

/**
 * @template-covariant TValue of array-key
 */
interface IdValueGeneratorInterface
{
    /**
     * @return TValue
     * @throws IdOverflowException occurs in case of ID creation errors
     */
    public function nextId(): mixed;
}
