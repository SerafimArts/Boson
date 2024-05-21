<?php

declare(strict_types=1);

namespace Local\WebView2;

enum WebResourceContext: int
{
    case CONTEXT_ALL = 0;
    case CONTEXT_DOCUMENT = 1;
    case CONTEXT_STYLESHEET = 2;
    case CONTEXT_IMAGE = 3;
    case CONTEXT_MEDIA = 4;
    case CONTEXT_FONT = 5;
    case CONTEXT_SCRIPT = 6;
    case CONTEXT_XML_HTTP_REQUEST = 7;
    case CONTEXT_FETCH = 8;
    case CONTEXT_TEXT_TRACK = 9;
    case CONTEXT_EVENT_SOURCE = 10;
    case CONTEXT_WEBSOCKET = 11;
    case CONTEXT_MANIFEST = 12;
    case CONTEXT_SIGNED_EXCHANGE = 13;
    case CONTEXT_PING = 14;
    case CONTEXT_CSP_VIOLATION_REPORT = 15;
    case CONTEXT_OTHER = 16;
}
