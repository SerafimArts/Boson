<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Manager;

use Serafim\Boson\Window\WindowInterface;

/**
 * @template-extends \Traversable<array-key, WindowInterface>
 */
interface WindowManagerInterface extends \Traversable, \Countable
{
    /**
     * Gets default window instance.
     *
     * It may be {@see null} in case of window has been closed (removed) earlier.
     */
    public ?WindowInterface $default { get; }

    /**
     * Gets count of available windows.
     *
     * @return int<0, max>
     */
    public function count(): int;
}
