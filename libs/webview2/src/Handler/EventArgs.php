<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use FFI\CData;
use Local\Com\IUnknown;
use Local\WebView2\WebView2;

/**
 * @template-extends IUnknown<WebView2>
 */
abstract class EventArgs extends IUnknown
{
    public function __construct(WebView2 $ffi, CData $cdata)
    {
        parent::__construct($ffi, $cdata);
    }
}
