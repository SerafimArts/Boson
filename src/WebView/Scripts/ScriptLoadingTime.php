<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Scripts;

enum ScriptLoadingTime
{
    /**
     * The script will be loaded as soon as the document is created.
     */
    case OnCreated;

    /**
     * The script will be loaded as soon as the DOM is ready.
     */
    case OnReady;
}
