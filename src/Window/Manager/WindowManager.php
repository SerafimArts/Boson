<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Manager;

use Serafim\Boson\Application;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Dispatcher\EventDispatcherInterface;
use Serafim\Boson\Internal\Application\ProcessUnlockPlaceholder;
use Serafim\Boson\Internal\Memory\ReactiveWeakSet;
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

    /**
     * @var ReactiveWeakSet<Window>
     */
    private readonly ReactiveWeakSet $memory;

    private readonly DelegateEventListener $events;

    public function __construct(
        private readonly LibSaucer $api,
        private readonly Application $app,
        private readonly ProcessUnlockPlaceholder $placeholder,
        WindowCreateInfo $info,
        EventDispatcherInterface $dispatcher,
    ) {
        $this->windows = new \SplObjectStorage();
        $this->memory = new ReactiveWeakSet();

        $this->events = new DelegateEventListener($dispatcher);

        $this->registerDefaultEventListeners();

        $this->default = $this->create($info);
    }

    private function registerDefaultEventListeners(): void
    {
        $this->events->addEventListener(WindowClosed::class, $this->onWindowClosed(...));
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
            placeholder: $this->placeholder,
            app: $this->app,
            info: $info,
            dispatcher: $this->events,
        ));

        $this->memory->watch($window, function (Window $window): void {
            $this->api->saucer_webview_clear_scripts($window->id->ptr);
            $this->api->saucer_webview_clear_embedded($window->id->ptr);
            $this->api->saucer_free($window->id->ptr);
        });

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
