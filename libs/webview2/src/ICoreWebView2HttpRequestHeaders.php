<?php

declare(strict_types=1);

namespace Local\WebView2;

use Local\Com\Attribute\MapStruct;
use Local\Com\WideString;
use Local\WebView2\Iterator\HttpHeadersCollectionIterator;
use Local\WebView2\Shared\IUnknown;

/**
 * @template-extends \IteratorAggregate<string, string>
 */
#[MapStruct(name: 'ICoreWebView2HttpRequestHeaders', owned: false)]
final class ICoreWebView2HttpRequestHeaders extends IUnknown implements \IteratorAggregate
{
    public function removeHeader(string $name): void
    {
        $this->call('RemoveHeader', [
            WideString::toWideString($name),
        ]);
    }

    public function setHeader(string $name, string $value): void
    {
        $this->call('SetHeader', [
            WideString::toWideString($name),
            WideString::toWideString($value),
        ]);
    }

    public function contains(string $name): bool
    {
        $this->call('Contains', [
            WideString::toWideString($name),
            \FFI::addr($value = $this->ffi->new('BOOL')),
        ]);

        return $value->cdata === 1;
    }

    public function getHeader(string $name): ?string
    {
        $result = $this->callGetResult('GetHeader', [
            WideString::toWideString($name),
            \FFI::addr($value = $this->ffi->new('LPWSTR')),
        ]);

        if ($result !== 0) {
            return null;
        }

        return WideString::fromWideString($value);
    }

    /**
     * @return \Traversable<string, string>
     */
    public function getHeaders(string $name): \Traversable
    {
        // Using "$collection" variable to keep a pointer to a collection in PHP GC
        $pointer = \FFI::addr($collection = HttpHeadersCollectionIterator::new($this->ffi));

        $this->call('GetHeaders', [
            WideString::toWideString($name),
            \FFI::addr($pointer),
        ]);

        try {
            return new HttpHeadersCollectionIterator($this->ffi, $pointer);
        } finally {
            unset($collection);
        }
    }

    public function getIterator(): \Traversable
    {
        return HttpHeadersCollectionIterator::from($this);
    }

    /**
     * @return array<string, string>
     * @throws \Exception
     */
    public function toArray(): array
    {
        return \iterator_to_array($this->getIterator());
    }
}
