<?php

declare(strict_types=1);

namespace Local\WebView2\Shared;

use Local\WebView2\Handler\EventArgs;
use Local\WebView2\Handler\EventHandler;
use Local\WebView2\Handler\EventSubscription;

/**
 * @mixin IUnknown
 * @phpstan-require-extends IUnknown
 */
trait ContainEventHandlers
{
    /**
     * @var list<EventSubscription>
     */
    private array $listeners = [];

    /**
     * @template TEventArgs of EventArgs
     * @param non-empty-string $name
     * @param class-string<EventHandler> $class
     * @param callable(TEventArgs):void $then
     * @return EventSubscription<TEventArgs>
     */
    protected function addEventListener(string $name, string $class, callable $then): EventSubscription
    {
        return $this->listeners[] = $class::create($this->ffi, $then)
            ->listen($this, $name);
    }

    protected function tearDownContainEventHandlers(): void
    {
        foreach ($this->listeners as $listener) {
            $listener->cancel();
        }

        $this->listeners = [];
    }
}
