<?php

declare(strict_types=1);

namespace Local\WebView2\Internal;

use Local\Com\Attribute\MapStruct;
use Local\WebView2\Shared\IUnknown;

#[MapStruct('IStream', owned: false)]
final class IStream extends IUnknown {}
