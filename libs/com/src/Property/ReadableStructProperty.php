<?php

declare(strict_types=1);

namespace Local\Com\Property;

use FFI\CData;
use Local\Com\Struct;
use Local\Property\ReadablePropertyInterface;

/**
 * @template T of Struct
 * @template-implements ReadablePropertyInterface<T>
 */
final class ReadableStructProperty implements ReadablePropertyInterface
{
    /**
     * @var \Closure(CData):T
     */
    private readonly \Closure $initializer;

    /**
     * @var T|null
     */
    private ?Struct $value = null;

    /**
     * @param Struct<object> $context Same as {@see Property::$context}.
     * @param non-empty-string $name Same as {@see Property::$name}.
     * @param class-string<T> $struct The class name of the structure (as well
     *        as the type) contained in the property.
     * @param (callable(CData):T)|null $initializer Structure object constructor.
     *        In case of the initializer is {@see null}, a default constructor
     *        will be created.
     */
    public function __construct(
        private readonly Struct $context,
        private readonly string $name,
        private readonly string $struct,
        ?callable $initializer = null,
        private readonly bool $once = true,
    ) {
        if ($initializer === null) {
            $initializer = $this->createDefaultInitializer();
        }

        $this->initializer = $initializer(...);
    }

    /**
     * @return \Closure(CData):T
     */
    private function createDefaultInitializer(): \Closure
    {
        return fn (CData $struct): Struct => new ($this->struct)(
            $this->context->ffi,
            $struct,
        );
    }

    /**
     * @return T
     */
    public function get(): Struct
    {
        if ($this->value !== null && $this->once) {
            return $this->value;
        }

        $cdata = \FFI::addr(($this->struct)::new($this->context->ffi, false));

        ($this->context->vt->{'get_' . $this->name})(
            $this->context->cdata,
            \FFI::addr($cdata),
        );

        $this->value = ($this->initializer)($cdata);
        $this->value->markAsNonOwned();

        return $this->value;
    }
}
