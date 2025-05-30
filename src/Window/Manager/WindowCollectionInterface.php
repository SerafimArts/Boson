<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Manager;

use Serafim\Boson\Window\Window;

/**
 * @template-extends \Traversable<array-key, Window>
 */
interface WindowCollectionInterface extends \Traversable, \Countable
{
    /**
     * Gets count of available windows.
     *
     * @return int<0, max>
     */
    public function count(): int;
}
