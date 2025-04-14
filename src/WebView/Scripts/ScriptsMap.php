<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Scripts;

use FFI\CData;
use JetBrains\PhpStorm\Language;
use Serafim\Boson\Internal\Saucer\LibSaucer;
use Serafim\Boson\Internal\Saucer\SaucerLoadTime;
use Serafim\Boson\WebView\WebView;

/**
 * @template-implements \IteratorAggregate<mixed, Script>
 */
final readonly class ScriptsMap implements ScriptsMapInterface, \IteratorAggregate
{
    /**
     * List of loaded scripts.
     *
     * @var \SplObjectStorage<Script, mixed>
     */
    private \SplObjectStorage $scripts;

    /**
     * An internal window handle pointer.
     */
    private CData $ptr;

    public function __construct(
        private LibSaucer $api,
        private WebView $webview,
    ) {
        $this->scripts = new \SplObjectStorage();
        $this->ptr = $this->webview->window->id->ptr;
    }

    public function exec(#[Language('JavaScript')] string $code): void
    {
        $this->api->saucer_webview_execute($this->ptr, $code);
    }

    public function preload(#[Language('JavaScript')] string $code): Script
    {
        $handle = $this->api->saucer_script_new($code, SaucerLoadTime::SAUCER_LOAD_TIME_CREATION);

        $this->registerAndInject($script = new Script(
            api: $this->api,
            id: ScriptId::fromScriptHandle($this->api, $handle),
            code: $code,
            time: ScriptLoadingTime::OnCreated,
        ));

        return $script;
    }

    public function add(#[Language('JavaScript')] string $code): Script
    {
        $handle = $this->api->saucer_script_new($code, SaucerLoadTime::SAUCER_LOAD_TIME_READY);

        $this->registerAndInject($script = new Script(
            api: $this->api,
            id: ScriptId::fromScriptHandle($this->api, $handle),
            code: $code,
            time: ScriptLoadingTime::OnReady,
        ));

        return $script;
    }

    private function registerAndInject(Script $script): void
    {
        $this->scripts->attach($script);

        $this->inject($script);
    }

    private function inject(Script $script): void
    {
        $this->api->saucer_webview_inject($this->ptr, $script->id->ptr);
    }

    public function count(): int
    {
        return \count($this->scripts);
    }

    public function getIterator(): \Traversable
    {
        return $this->scripts;
    }

    public function __destruct()
    {
        $this->api->saucer_webview_clear_scripts($this->ptr);
    }
}
