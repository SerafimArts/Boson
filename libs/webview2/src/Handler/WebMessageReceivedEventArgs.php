<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\Property\ReadableWideStringProperty;
use Local\Com\WideString;
use Local\Property\Attribute\MapGetter;
use Local\WebView2\WebView2;

/**
 * @property-read string $source
 * @property-read string $webMessageAsJson
 */
#[MapStruct(name: 'ICoreWebView2WebMessageReceivedEventArgs', owned: false)]
final class WebMessageReceivedEventArgs extends EventArgs
{
    protected readonly ReadableWideStringProperty $sourceProperty;
    protected readonly ReadableWideStringProperty $webMessageAsJsonProperty;

    public function __construct(WebView2 $ffi, CData $cdata)
    {
        parent::__construct($ffi, $cdata);

        $this->sourceProperty = new ReadableWideStringProperty($this, 'Source');
        $this->webMessageAsJsonProperty = new ReadableWideStringProperty($this, 'WebMessageAsJson');
    }

    /**
     * @api
     */
    #[MapGetter('source')]
    public function getSource(): string
    {
        return $this->sourceProperty->get();
    }

    /**
     * @api
     */
    #[MapGetter('webMessageAsJson')]
    public function getWebMessageAsJson(): string
    {
        return $this->webMessageAsJsonProperty->get();
    }

    /**
     * @api
     */
    public function tryGetWebMessageAsString(): string
    {
        /** @var CData $message */
        $message = $this->ffi->new('LPWSTR');

        ($this->vt->TryGetWebMessageAsString)(
            $this->cdata,
            \FFI::addr($message),
        );

        return WideString::fromWideString($message);
    }
}
