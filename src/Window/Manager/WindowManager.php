<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Manager;

use Serafim\Boson\Application;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Dispatcher\EventDispatcherInterface;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Window\Window;
use Serafim\Boson\Window\WindowCreateInfo;
use Serafim\Boson\Window\WindowInterface;

/**
 * @template-implements \IteratorAggregate<array-key, WindowInterface>
 */
final class WindowManager implements
    WindowManagerInterface,
    \IteratorAggregate
{
    public ?WindowInterface $default {
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

    private readonly DelegateEventListener $events;

    public function __construct(
        private readonly LibSaucer $api,
        private readonly Application $app,
        WindowCreateInfo $info,
        EventDispatcherInterface $dispatcher,
    ) {
        $this->events = new DelegateEventListener($dispatcher);

        $this->create($info);
    }

    public function create(WindowCreateInfo $info = new WindowCreateInfo()): WindowInterface
    {
        return $this->windows[] = new Window(
            api: $this->api,
            app: $this->app,
            info: $info,
            dispatcher: $this->events,
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
