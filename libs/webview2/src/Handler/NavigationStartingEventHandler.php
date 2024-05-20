<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use Local\Com\Attribute\MapStruct;
use Local\WebView2\Attribute\MapEventArgs;

/**
 * @template-extends EventHandler<NavigationStartingEventArgs>
 */
#[MapEventArgs(class: NavigationStartingEventArgs::class)]
#[MapStruct(name: 'ICoreWebView2NavigationStartingEventHandler')]
final class NavigationStartingEventHandler extends EventHandler {}
