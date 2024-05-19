<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use FFI\CData;
use Local\Com\Attribute\MapCallback;
use Local\Com\IUnknown;
use Local\Com\Struct;
use Local\WebView2\Attribute\MapEventArgs;
use Local\WebView2\WebView2;

/**
 * @template T of mixed
 *
 * @template-extends IUnknown<WebView2>
 */
abstract class EventHandler extends IUnknown
{
    /**
     * @param \Closure(T):void $callback
     */
    final public function __construct(
        WebView2 $ffi,
        CData $cdata,
        private readonly \Closure $callback,
    ) {
        parent::__construct($ffi, $cdata);
    }

    /**
     * @param Struct<WebView2> $context
     * @param non-empty-string $event
     */
    public function listen(Struct $context, string $event): EventSubscription
    {
        /** @var CData $token */
        $token = $this->ffi->new('EventRegistrationToken');

        // @phpstan-ignore-next-line
        ($context->vt->{'add_' . $event})(
            $context->cdata,
            \FFI::addr($this->cdata),
            \FFI::addr($token),
        );

        return new EventSubscription(
            context: $context,
            cdata: $token,
            name: $event,
        );
    }

    /**
     * @return class-string<EventArgs>
     */
    protected static function getEventArgs(): string
    {
        $reflection = new \ReflectionClass(static::class);


        foreach ($reflection->getAttributes(MapEventArgs::class) as $attribute) {
            /** @var MapEventArgs $instance */
            $instance = $attribute->newInstance();

            return $instance->class;
        }

        throw new \LogicException('Could not find referenced EventArgs');
    }

    /**
     * @api
     */
    #[MapCallback('Invoke')]
    protected function onInvoke(CData $self, CData $sender, CData $args): int
    {
        try {
            ($this->callback)($args);

            return 0;
        } catch (\Throwable $e) {
            $code = $e->getCode();

            return $code === 0 ? 1 : $code;
        }
    }

    /**
     * @template TArg of mixed
     * @param callable(TArg):void $callback
     * @return static<TArg>
     */
    public static function create(WebView2 $ffi, callable $callback): static
    {
        $struct = static::new($ffi);

        return new static($ffi, $struct, static function (CData $struct) use ($ffi, $callback): void {
            $class = static::getEventArgs();

            // @phpstan-ignore-next-line
            $callback(new $class($ffi, $struct));
        });
    }
}
