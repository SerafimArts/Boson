<?php

declare(strict_types=1);

namespace Local\WebView2;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\Property\Property;
use Local\Com\Property\ReadableStructProperty;
use Local\Com\Property\WideStringProperty;
use Local\Property\Attribute\MapGetter;
use Local\Property\Attribute\MapSetter;
use Local\WebView2\Internal\IStream;
use Local\WebView2\Shared\IUnknown;

/**
 * @property string $uri
 * @property string $method
 * @property-read IStream $content
 * @property-read ICoreWebView2HttpRequestHeaders $headers
 */
#[MapStruct('ICoreWebView2WebResourceRequest', owned: true)]
final class ICoreWebView2WebResourceRequest extends IUnknown
{
    protected readonly WideStringProperty $uriProperty;
    protected readonly WideStringProperty $methodProperty;

    /**
     * @var ReadableStructProperty<IStream>
     */
    protected readonly ReadableStructProperty $contentProperty;

    /**
     * @var ReadableStructProperty<ICoreWebView2HttpRequestHeaders>
     */
    protected readonly ReadableStructProperty $headersProperty;

    public function __construct(object $ffi, CData $cdata)
    {
        parent::__construct($ffi, $cdata);

        $this->uriProperty = new WideStringProperty($this, 'Uri');
        $this->methodProperty = new WideStringProperty($this, 'Method');
        $this->contentProperty = new ReadableStructProperty(
            context: $this,
            name: 'Content',
            struct: IStream::class,
        );
        $this->headersProperty = new ReadableStructProperty(
            context: $this,
            name: 'Headers',
            struct: ICoreWebView2HttpRequestHeaders::class,
        );
    }

    /**
     * @api
     */
    #[MapGetter('uri')]
    public function getUri(): string
    {
        return $this->uriProperty->get();
    }

    /**
     * @api
     */
    #[MapSetter('uri')]
    public function setUri(string $uri): void
    {
        $this->uriProperty->set($uri);
    }

    /**
     * @api
     */
    #[MapGetter('method')]
    public function getMethod(): string
    {
        return $this->methodProperty->get();
    }

    /**
     * @api
     */
    #[MapSetter('method')]
    public function setMethod(string $uri): void
    {
        $this->methodProperty->set($uri);
    }

    /**
     * @api
     */
    #[MapGetter('content')]
    public function getContent(): IStream
    {
        return $this->contentProperty->get();
    }

    /**
     * @api
     */
    #[MapGetter('headers')]
    public function getHeaders(): ICoreWebView2HttpRequestHeaders
    {
        return $this->headersProperty->get();
    }
}
