<?php

declare(strict_types=1);

namespace Local\WebView2;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\Property\ReadableStructProperty;
use Local\Property\Attribute\MapGetter;
use Local\WebView2\Shared\IUnknown;

/**
 * @property-read ICoreWebView2HttpRequestHeaders $headers
 */
#[MapStruct('ICoreWebView2WebResourceResponse', owned: true)]
final class ICoreWebView2WebResourceResponse extends IUnknown
{
    protected readonly ReadableStructProperty $headersProperty;

    public function __construct(object $ffi, CData $cdata)
    {
        parent::__construct($ffi, $cdata);

        $this->headersProperty = new ReadableStructProperty(
            context: $this,
            name: 'Headers',
            struct: ICoreWebView2HttpRequestHeaders::class,
        );
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
