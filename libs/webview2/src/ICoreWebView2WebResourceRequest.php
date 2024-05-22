<?php

declare(strict_types=1);

namespace Local\WebView2;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\Property\ReadableStructProperty;
use Local\Com\Property\WideStringProperty;
use Local\Property\Attribute\MapGetter;
use Local\Property\Attribute\MapSetter;
use Local\WebView2\Shared\IUnknown;

/**
 * @property string $uri
 * @property string $method
 * @property string $content
 * @property-read ICoreWebView2HttpRequestHeaders $headers
 */
#[MapStruct('ICoreWebView2WebResourceRequest', owned: true)]
final class ICoreWebView2WebResourceRequest extends IUnknown
{
    protected readonly WideStringProperty $uriProperty;
    protected readonly WideStringProperty $methodProperty;
    protected readonly WideStringProperty $contentProperty;
    protected readonly ReadableStructProperty $headersProperty;

    public function __construct(object $ffi, CData $cdata)
    {
        parent::__construct($ffi, $cdata);

        $this->uriProperty = new WideStringProperty($this, 'Uri');
        $this->methodProperty = new WideStringProperty($this, 'Method');
        $this->contentProperty = new WideStringProperty($this, 'Content');
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
    public function getContent(): string
    {
        return $this->contentProperty->get();
    }

    /**
     * @api
     */
    #[MapSetter('content')]
    public function setContent(string $uri): void
    {
        $this->contentProperty->set($uri);
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
