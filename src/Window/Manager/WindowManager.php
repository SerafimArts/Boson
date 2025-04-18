<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Manager;

use Serafim\Boson\Application;
use Serafim\Boson\Dispatcher\DelegateEventListener;
use Serafim\Boson\Dispatcher\EventDispatcherInterface;
use Serafim\Boson\Dispatcher\EventListener;
use Serafim\Boson\Internal\ProcessUnlockPlaceholder;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Shared\GarbageCollector\ObservableWeakSet;
use Serafim\Boson\Window\Event\WindowClosed;
use Serafim\Boson\Window\Event\WindowCreated;
use Serafim\Boson\Window\Window;
use Serafim\Boson\Window\WindowCreateInfo;

/**
 * @template-implements \IteratorAggregate<array-key, Window>
 */
final class WindowManager implements
    WindowCollectionInterface,
    WindowFactoryInterface,
    \IteratorAggregate
{
    /**
     * Gets default window instance.
     *
     * It may be {@see null} in case of window has been
     * closed (removed) earlier.
     */
    public private(set) ?Window $default;

    /**
     * Contains a list of all windows in use.
     *
     * @var \SplObjectStorage<Window, mixed>
     */
    private readonly \SplObjectStorage $windows;

    /**
     * Contains a list of subscriptions for window destruction.
     *
     * @var ObservableWeakSet<Window>
     */
    private readonly ObservableWeakSet $memory;

    /**
     * Gets access to the listener of ANY window events
     * and intention subscriptions.
     */
    public readonly EventListener $events;

    public function __construct(
        private readonly LibSaucer $api,
        private readonly Application $app,
        private readonly ProcessUnlockPlaceholder $placeholder,
        WindowCreateInfo $info,
        EventDispatcherInterface $dispatcher,
    ) {
        $this->windows = new \SplObjectStorage();
        $this->memory = new ObservableWeakSet();

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

    public function create(WindowCreateInfo $info = new WindowCreateInfo()): Window
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

        $this->events->dispatch(new WindowCreated($window));

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
