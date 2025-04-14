<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Binding;

use Serafim\Boson\WebView\Binding\Exception\FunctionAlreadyDefinedException;
use Serafim\Boson\WebView\Binding\Exception\FunctionNotDefinedException;

/**
 * @template-extends \Traversable<non-empty-string, \Closure(mixed...):mixed>
 */
interface FunctionsMapInterface extends \Traversable, \Countable
{
    /**
     * Binds a function to a new global JavaScript function
     *
     * Internally, JS glue code is injected to create the JS
     * function by the given name
     *
     * @param non-empty-string $function The name of the JS function
     * @param \Closure(mixed...):mixed $callback Callback function
     *
     * @throws FunctionAlreadyDefinedException in case of function binding error
     */
    public function add(string $function, \Closure $callback): void;

    /**
     * Removes a binding created with {@see FunctionsMapInterface::add()}
     *
     * @param non-empty-string $function The name of the JS function
     *
     * @throws FunctionNotDefinedException in case of function unbinding error
     */
    public function remove(string $function): void;

    /**
     * The number of registered functions (cannot be less than 0)
     *
     * @return int<0, max>
     */
    public function count(): int;
}
