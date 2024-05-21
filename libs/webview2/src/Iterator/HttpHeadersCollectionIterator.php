<?php

declare(strict_types=1);

namespace Local\WebView2\Iterator;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\Property\ReadableBoolProperty;
use Local\Com\WideString;

/**
 * @template-extends Iterator<string, string>
 */
#[MapStruct(name: 'ICoreWebView2HttpHeadersCollectionIterator', owned: true)]
final class HttpHeadersCollectionIterator extends Iterator
{
    private readonly ReadableBoolProperty $hasHasCurrentHeader;

    public function __construct(object $ffi, CData $cdata)
    {
        parent::__construct($ffi, $cdata);

        $this->hasHasCurrentHeader = new ReadableBoolProperty(
            context: $this,
            name: 'HasCurrentHeader',
            once: false,
        );
    }

    public function getIterator(): \Traversable
    {
        if (!$this->hasHasCurrentHeader->get()) {
            return;
        }

        do {
            $this->call('GetCurrentHeader', [
                \FFI::addr($key = $this->ffi->new('LPWSTR')),
                \FFI::addr($value = $this->ffi->new('LPWSTR')),
            ]);

            yield WideString::fromWideString($key) => WideString::fromWideString($value);
        } while ($this->next());
    }
}
