<?php

declare(strict_types=1);

namespace Local\WebView2\Handler;

use Local\Com\Attribute\MapStruct;
use Local\WebView2\Attribute\MapEventArgs;

/**
 * @template-extends EventHandler<NavigationCompletedEventArgs>
 */
#[MapEventArgs(class: NavigationCompletedEventArgs::class)]
#[MapStruct(name: 'ICoreWebView2NavigationCompletedEventHandler')]
final class NavigationCompletedEventHandler extends EventHandler {}
