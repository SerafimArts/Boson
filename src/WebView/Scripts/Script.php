<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Scripts;

use JetBrains\PhpStorm\Language;
use Serafim\Boson\Internal\Saucer\LibSaucer;

final readonly class Script implements \Stringable
{
    public function __construct(
        private LibSaucer $api,
        public ScriptId $id,
        #[Language('JavaScript')]
        public string $code,
        public ScriptLoadingTime $time,
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
