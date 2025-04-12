<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Manager;

use FFI\CData;
use Serafim\Boson\Application;
use Serafim\Boson\Shared\Saucer\LibSaucer;
use Serafim\Boson\Window\Window;
use Serafim\Boson\Window\WindowCreateInfo;
use Serafim\Boson\Window\WindowInterface;

/**
 * @template-extends \Traversable<array-key, WindowInterface>
 */
final class WindowManager implements
    WindowFactoryInterface,
    WindowManagerInterface,
    \IteratorAggregate
{
    public WindowInterface $default {
        get {
            $first = \reset($this->windows);

            if ($first === false) {
                return null;
            }

            return $first;
        }
    }

    /**
     * @var list<WindowInterface>
     */
    private array $windows = [];

    public function __construct(
        private readonly LibSaucer $api,
        private readonly Application $app,
        WindowCreateInfo $info,
    ) {
        $this->create($info);
    }

    public function create(WindowCreateInfo $info = new WindowCreateInfo()): WindowInterface
    {
        return $this->windows[] = new Window(
            api: $this->api,
            app: $this->app,
            info: $info
        );
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->windows);
    }

    public function count(): int
    {
        return \count($this->windows);
    }
}
