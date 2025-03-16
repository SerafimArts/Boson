<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Binding;

use FFI\CData;
use Serafim\Boson\Core\Runtime\WebViewLibrary;
use Serafim\Boson\Exception\WebViewFunctionAlreadyRegisteredException;

/**
 * @template TFunction of \Closure = \Closure
 *
 * @template-implements WebViewFunctionsInterface<TFunction>
 * @template-implements \IteratorAggregate<non-empty-string, TFunction>
 */
final class WebViewFunctions implements WebViewFunctionsInterface, \IteratorAggregate
{
    /**
     * @var array<non-empty-string, WebViewFunction<TFunction>>
     */
    private array $functions = [];

    public function __construct(
        private readonly WebViewLibrary $api,
        private readonly CData $webview,
    ) {}

    public function add(string $function, \Closure $callback): void
    {
        if (isset($this->functions[$function])) {
            throw WebViewFunctionAlreadyRegisteredException::becauseFunctionAlreadyRegistered($function);
        }

        $handler = new WebViewFunction($this->api, $this->webview, $callback(...));

        $this->api->webview_bind($this->webview, $function, $handler(...), null);

        $this->functions[$function] = $handler;
    }

    public function remove(string $function): void
    {
        if (!isset($this->functions[$function])) {
            return;
        }

        $this->api->webview_unbind($this->webview, $function);
        unset($this->functions[$function]);
    }

    public function getIterator(): \Traversable
    {
        foreach ($this->functions as $name => $function) {
            yield $name => $function->callback;
        }
    }

    public function count(): int
    {
        return \count($this->functions);
    }
}
