<?php

declare(strict_types=1);

namespace Local\Id\IdGenerator;

use Local\Id\Exception\IdExceptionInterface;
use Local\Id\IdInterface;

/**
 * @template TValue of mixed
 */
interface GeneratorInterface
{
    /**
     * @throws IdExceptionInterface Occurs in case of ID creation errors.
     *
     * @return IdInterface<TValue>
     */
    public function nextId(): IdInterface;
}
