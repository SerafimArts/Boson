<?php

declare(strict_types=1);

namespace Local\WebView2\Callback;

use FFI\CData;
use Local\Com\Attribute\MapCallback;
use Local\Com\Exception\ResultException;
use Local\Com\IUnknown;
use Local\WebView2\WebView2;

/**
 * @template T of mixed
 *
 * @template-extends IUnknown<WebView2>
 */
abstract class CallbackHandler extends IUnknown
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
     * @api
     */
    #[MapCallback('Invoke')]
    protected function onInvoke(CData $self, int $result, mixed $data): int
    {
        if ($result !== 0) {
            throw ResultException::fromCallbackMetadata(
                meta: static::getStructMetadata(),
                method: __FUNCTION__,
                code: $result,
            );
        }

        try {
            ($this->callback)($data);

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

        return new static($ffi, $struct, $callback(...));
    }
}
