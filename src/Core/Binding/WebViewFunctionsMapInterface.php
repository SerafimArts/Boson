<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\Binding;

use Serafim\Boson\Exception\WebViewException;

/**
 * @template TFunction of \Closure = \Closure
 * @template-extends \Traversable<non-empty-string, TFunction>
 */
interface WebViewFunctionsMapInterface extends \Traversable, \Countable
{
    /**
     * Binds a function to a new global JavaScript function
     *
     * Internally, JS glue code is injected to create the JS
     * function by the given name
     *
     * @param non-empty-string $function The name of the JS function
     * @param TFunction $callback Callback function
     *
     * @throws WebViewException in case of function binding error
     */
    public function add(string $function, \Closure $callback): void;

    /**
     * Removes a binding created with {@see WebViewFunctionsMapInterface::add()}
     *
     * @param non-empty-string $function The name of the JS function
     *
     * @throws WebViewException in case of function unbinding error
     */
    public function remove(string $function): void;

    /**
     * The number of registered functions (cannot be less than 0)
     *
     * @return int<0, max>
     */
    public function count(): int;
}
