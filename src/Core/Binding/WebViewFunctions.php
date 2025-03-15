<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Binding;

use FFI\CData;
use Serafim\Boson\Core\Runtime\WebViewLibrary;

/**
 * @template-implements \IteratorAggregate<non-empty-string, callable>
 */
final class WebViewFunctions implements \IteratorAggregate, \Countable
{
    /**
     * @var array<non-empty-string, WebViewFunction>
     */
    private array $functions = [];

    public function __construct(
        private readonly WebViewLibrary $api,
        private readonly CData $webview,
    ) {}

    /**
     * @param non-empty-string $name The
     * @return bool Returns {@see true} in case of function has been
     *         registered or {@see false} instead
     */
    public function add(string $name, callable $callback): bool
    {
        if (isset($this->functions[$name])) {
            return false;
        }

        $handler = new WebViewFunction($this->api, $this->webview, $callback(...));

        $this->api->webview_bind($this->webview, $name, $handler(...), null);

        $this->functions[$name] = $handler;

        return true;
    }

    /**
     * @param non-empty-string $name
     */
    public function remove(string $name): bool
    {
        if (isset($this->functions[$name])) {
            $this->api->webview_unbind($this->webview, $name);
            unset($this->functions[$name]);

            return true;
        }

        return false;
    }

    public function getIterator(): \Traversable
    {
        foreach ($this->functions as $name => $function) {
            yield $name => $function->callback;
        }
    }

    /**
     * @return int<0, max>
     */
    public function count(): int
    {
        return \count($this->functions);
    }
}
