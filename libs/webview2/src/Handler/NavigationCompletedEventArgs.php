<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\Property\ReadableBoolProperty;
use Local\Com\Property\ReadableIntProperty;
use Local\Property\Attribute\MapGetter;
use Local\WebView2\WebErrorStatus;
use Local\WebView2\WebView2;

/**
 * @property-read bool $isSuccess
 * @property-read WebErrorStatus $webErrorStatus
 * @property-read int $navigationId
 */
#[MapStruct(name: 'ICoreWebView2NavigationCompletedEventHandler', owned: false)]
final class NavigationCompletedEventArgs extends EventArgs
{
    protected readonly ReadableBoolProperty $isSuccessProperty;
    protected readonly ReadableIntProperty $navigationIdProperty;
    protected readonly ReadableIntProperty $webErrorStatusProperty;

    public function __construct(WebView2 $ffi, CData $cdata)
    {
        parent::__construct($ffi, $cdata);

        $this->isSuccessProperty = new ReadableBoolProperty($this, 'IsSuccess');
        $this->webErrorStatusProperty = new ReadableIntProperty($this, 'WebErrorStatus', 'COREWEBVIEW2_WEB_ERROR_STATUS');
        $this->navigationIdProperty = new ReadableIntProperty($this, 'NavigationId', 'UINT64');
    }

    /**
     * @api
     */
    #[MapGetter(name: 'isSuccess')]
    public function isSuccess(): bool
    {
        return $this->isSuccessProperty->get();
    }

    /**
     * @api
     */
    #[MapGetter(name: 'webErrorStatus')]
    public function getWebErrorStatus(): WebErrorStatus
    {
        $value = $this->webErrorStatusProperty->get();

        return WebErrorStatus::tryFrom($value)
            ?? WebErrorStatus::STATUS_UNKNOWN;
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
