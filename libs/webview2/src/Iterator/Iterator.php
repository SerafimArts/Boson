<?php

declare(strict_types=1);

namespace Local\WebView2\Iterator;

use Local\WebView2\Shared\IUnknown;

/**
 * @template TKey of mixed
 * @template TValue of mixed
 * @template-extends \IteratorAggregate<TKey, TValue>
 */
abstract class Iterator extends IUnknown implements \IteratorAggregate
{
    public static function from(IUnknown $struct): static
    {
        // Using "$collection" variable to keep a pointer to a collection in PHP GC
        $pointer = \FFI::addr($collection = static::new($struct->ffi));

        $struct->call('GetIterator', [\FFI::addr($pointer)]);

        try {
            return new static($struct->ffi, $pointer);
        } finally {
            unset($collection);
        }
    }

    protected function next(): bool
    {
        $this->call('MoveNext', [
            \FFI::addr($value = $this->ffi->new('BOOL')),
        ]);

        return $value->cdata === 1;
    }
}
