<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\Property\ReadableIntProperty;
use Local\Com\Property\ReadableStructProperty;
use Local\Property\Attribute\MapGetter;
use Local\WebView2\ICoreWebView2WebResourceRequest;
use Local\WebView2\ICoreWebView2WebResourceResponse;
use Local\WebView2\WebResourceContext;
use Local\WebView2\WebView2;

/**
 * @property-read ICoreWebView2WebResourceRequest $request
 * @property-read ICoreWebView2WebResourceResponse $response
 * @property-read WebResourceContext $resourceContext
 */
#[MapStruct(name: 'ICoreWebView2WebResourceRequestedEventArgs', owned: false)]
final class WebResourceRequestedEventArgs extends EventArgs
{
    protected readonly ReadableStructProperty $requestProperty;
    protected readonly ReadableStructProperty $responseProperty;
    protected readonly ReadableIntProperty $resourceContextProperty;

    public function __construct(WebView2 $ffi, CData $cdata)
    {
        parent::__construct($ffi, $cdata);

        $this->requestProperty = new ReadableStructProperty(
            context: $this,
            name: 'Request',
            struct: ICoreWebView2WebResourceRequest::class,
        );

        $this->responseProperty = new ReadableStructProperty(
            context: $this,
            name: 'Response',
            struct: ICoreWebView2WebResourceResponse::class,
        );

        $this->resourceContextProperty = new ReadableIntProperty(
            context: $this,
            name: 'ResourceContext',
            type: 'COREWEBVIEW2_WEB_RESOURCE_CONTEXT',
        );
    }

    /**
     * @api
     */
    #[MapGetter('request')]
    public function getRequest(): ICoreWebView2WebResourceRequest
    {
        return $this->requestProperty->get();
    }

    /**
     * @api
     */
    #[MapGetter('response')]
    public function getResponse(): ICoreWebView2WebResourceResponse
    {
        return $this->responseProperty->get();
    }

    /**
     * @api
     */
    #[MapGetter('resourceContext')]
    public function getResourceContext(): WebResourceContext
    {
        $value = $this->resourceContextProperty->get();

        return WebResourceContext::tryFrom($value)
            ?? WebResourceContext::CONTEXT_OTHER;
    }
}
