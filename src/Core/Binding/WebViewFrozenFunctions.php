<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Binding;

use Serafim\Boson\Exception\WebViewBindingException;

/**
 * @template TFunction of \Closure = \Closure
 *
 * @template-implements WebViewFunctionsInterface<TFunction>
 * @template-implements \IteratorAggregate<non-empty-string, TFunction>
 */
final readonly class WebViewFrozenFunctions implements WebViewFunctionsInterface, \IteratorAggregate
{
    public function __construct(
        private WebViewFunctions $functions,
    ) {}

    /**
     * @return never
     * @phpstan-ignore-next-line : Known issue
     */
    public function add(string $function, \Closure $callback): void
    {
        throw new WebViewBindingException(\sprintf(
            'Unable to add function "%s" after launching an application',
            $function,
        ));
    }

    /**
     * @return never
     */
    public function remove(string $function): void
    {
        throw new WebViewBindingException(\sprintf(
            'Unable to remove function "%s" after app launch',
            $function,
        ));
    }

    public function getIterator(): \Traversable
    {
        return $this->functions->getIterator();
    }

    public function count(): int
    {
        return $this->functions->count();
    }
}
