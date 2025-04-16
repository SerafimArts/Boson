<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Scripts;

use Serafim\Boson\Internal\Saucer\LibSaucer;

final readonly class WebViewScript implements \Stringable
{
    public function __construct(
        private LibSaucer $api,
        public WebViewScriptId $id,
        public string $code,
        public WebViewScriptLoadingTime $time,
    ) {}

    public function __toString(): string
    {
        return $this->code;
    }

    public function __destruct()
    {
        $this->api->saucer_script_free($this->id->ptr);
    }
}
