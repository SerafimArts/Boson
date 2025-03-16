<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Binding;

use Serafim\Boson\Exception\WebViewBindingException;

/**
 * @template TFunction of \Closure = \Closure
 * @template-implements WebViewFunctionsMapInterface<TFunction>
 * @template-implements \IteratorAggregate<non-empty-string, TFunction>
 */
final readonly class WebViewFrozenFunctionsMap implements WebViewFunctionsMapInterface, \IteratorAggregate
{
    public function __construct(
        /**
         * @var WebViewFunctionsMapInterface<TFunction>
         */
        private WebViewFunctionsMapInterface $functions,
    ) {}

    public function add(string $function, \Closure $callback): never
    {
        throw new WebViewBindingException(\sprintf(
            'Unable to add function "%s" after launching an application',
            $function,
        ));
    }

    public function remove(string $function): never
    {
        throw new WebViewBindingException(\sprintf(
            'Unable to remove function "%s" after app launch',
            $function,
        ));
    }

    public function getIterator(): \Traversable
    {
        return $this->functions;
    }

    public function count(): int
    {
        return $this->functions->count();
    }
}
