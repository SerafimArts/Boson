<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Manager;

use Serafim\Boson\Application;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Dispatcher\EventDispatcherInterface;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Window\Event\WindowClosed;
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
    public private(set) ?WindowInterface $default;

    /**
     * @var \SplObjectStorage<WindowInterface, mixed>
     */
    private readonly \SplObjectStorage $windows;

    private readonly DelegateEventListener $events;

    public function __construct(
        private readonly LibSaucer $api,
        private readonly Application $app,
        WindowCreateInfo $info,
        EventDispatcherInterface $dispatcher,
    ) {
        $this->windows = new \SplObjectStorage();

        $this->events = new DelegateEventListener($dispatcher);
        $this->events->addEventListener(WindowClosed::class, $this->onWindowClosed(...));

        $this->default = $this->create($info);
    }

    private function onWindowClosed(WindowClosed $event): void
    {
        $this->windows->detach($event->subject);

        // Recalculate default window in case of
        // previous default window was closed.
        if ($this->default === $event->subject) {
            $this->default = $this->windows->count() > 0 ? $this->windows->current() : null;
        }
    }

    public function create(WindowCreateInfo $info = new WindowCreateInfo()): WindowInterface
    {
        $this->windows->attach($window = new Window(
            api: $this->api,
            app: $this->app,
            info: $info,
            dispatcher: $this->events,
        ));

        return $window;
    }

    public function getIterator(): \Traversable
    {
        return $this->windows;
    }

    public function count(): int
    {
        return $this->windows->count();
    }
}
