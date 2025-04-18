<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer\Frontend;

enum Runtime
{
    case Qt5;
    case Qt6;
    case Gtk4;
    case WebKit;
    case WebView2;
}
