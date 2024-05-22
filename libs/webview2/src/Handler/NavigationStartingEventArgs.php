<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\Property\BoolProperty;
use Local\Com\Property\ReadableBoolProperty;
use Local\Com\Property\ReadableIntProperty;
use Local\Com\Property\ReadableStructProperty;
use Local\Com\Property\ReadableWideStringProperty;
use Local\Property\Attribute\MapGetter;
use Local\Property\Attribute\MapSetter;
use Local\WebView2\ICoreWebView2HttpRequestHeaders;
use Local\WebView2\WebView2;

/**
 * @property-read string $uri
 * @property-read bool $isUserInitiated
 * @property-read bool $isRedirected
 * @property bool $cancel
 * @property-read int $navigationId
 * @property-read ICoreWebView2HttpRequestHeaders $requestHeaders
 */
#[MapStruct(name: 'ICoreWebView2NavigationStartingEventArgs', owned: false)]
final class NavigationStartingEventArgs extends EventArgs
{
    protected readonly ReadableWideStringProperty $uriProperty;
    protected readonly ReadableBoolProperty $isUserInitiatedProperty;
    protected readonly ReadableBoolProperty $isRedirectedProperty;
    protected readonly BoolProperty $cancelProperty;
    protected readonly ReadableIntProperty $navigationIdProperty;
    protected readonly ReadableStructProperty $requestHeadersProperty;

    public function __construct(WebView2 $ffi, CData $cdata)
    {
        parent::__construct($ffi, $cdata);

        $this->uriProperty = new ReadableWideStringProperty($this, 'Uri');
        $this->isUserInitiatedProperty = new ReadableBoolProperty($this, 'IsUserInitiated');
        $this->isRedirectedProperty = new ReadableBoolProperty($this, 'IsRedirected');
        $this->cancelProperty = new BoolProperty($this, 'Cancel');
        $this->navigationIdProperty = new ReadableIntProperty($this, 'NavigationId', 'UINT64');
        $this->requestHeadersProperty = new ReadableStructProperty(
            context: $this,
            name: 'RequestHeaders',
            struct: ICoreWebView2HttpRequestHeaders::class,
        );
    }

    /**
     * @api
     */
    #[MapGetter('requestHeaders')]
    public function getRequestHeaders(): ICoreWebView2HttpRequestHeaders
    {
        return $this->requestHeadersProperty->get();
    }

    /**
     * @api
     */
    #[MapGetter(name: 'uri')]
    public function getUri(): string
    {
        return $this->uriProperty->get();
    }

    /**
     * @api
     */
    #[MapGetter(name: 'isUserInitiated')]
    public function isUserInitiated(): bool
    {
        return $this->isUserInitiatedProperty->get();
    }

    /**
     * @api
     */
    #[MapGetter(name: 'isRedirected')]
    public function isRedirected(): bool
    {
        return $this->isRedirectedProperty->get();
    }

    /**
     * @api
     */
    #[MapGetter(name: 'isRedirected')]
    public function getCancel(): bool
    {
        return $this->cancelProperty->get();
    }

    /**
     * @api
     */
    #[MapSetter(name: 'isRedirected')]
    public function setCancel(bool $value): void
    {
        $this->cancelProperty->set($value);
    }

    /**
     * @api
     */
    #[MapGetter(name: 'navigationId')]
    public function getNavigationId(): int
    {
        return $this->navigationIdProperty->get();
    }
}
