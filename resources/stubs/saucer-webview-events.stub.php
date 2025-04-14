<?php

namespace Serafim\Boson\Internal\WebView;

use FFI\CData;
use Serafim\Boson\Internal\Saucer\SaucerState;

/**
 * @internal this is an INTERNAL STRUCT for PHPStan only, please do not use it in your code
 * @psalm-internal Serafim\Boson\Internal\WebView
 */
final class CSaucerWebViewEventsStruct extends CData
{
    /**
     * @var \Closure(CData):void
     */
    public \Closure $onDomReady;

    /**
     * @var \Closure(CData, string):void
     */
    public \Closure $onNavigated;

    /**
     * @var \Closure(CData, CData):void
     */
    public \Closure $onNavigating;

    /**
     * @var \Closure(CData, CData):void
     */
    public \Closure $onFaviconChanged;

    /**
     * @var \Closure(CData, string):void
     */
    public \Closure $onTitleChanged;

    /**
     * @var \Closure(CData, array{SaucerState::SAUCER_STATE_*}):void
     */
    public \Closure $onLoad;
}
