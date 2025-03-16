<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Requests\IdGenerator;

use Serafim\Boson\Exception\IdOverflowException;

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
