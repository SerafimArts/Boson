<?php

declare(strict_types=1);

namespace Local\Com\Property;

use FFI\CData;
use Local\Com\Struct;
use Local\Property\PropertyInterface;

/**
 * @template TRead of CData
 * @template TWrite of mixed
 * @template-implements PropertyInterface<TRead, TWrite>
 */
final class Property implements PropertyInterface
{
    /**
     * @var TRead
     */
    public readonly CData $value;

    /**
     * Contains {@see true} in case of property is initialized (getter has
     * been invoked) or {@see false} instead.
     */
    private bool $initialized = false;

    /**
     * @param Struct<object> $context The structure to which this property belongs.
     *        It is against this structure that the receiving (getter)
     *        methods will be called.
     * @param non-empty-string $name The name of the COM property from where
     *        the data should be obtained. Any COM property is a method with
     *        the "get_" prefix.
     * @param non-empty-string $type Native C type of the property.
     */
    public function __construct(
        private readonly Struct $context,
        private readonly string $name,
        private readonly string $type,
    ) {
        // @phpstan-ignore-next-line
        $this->value = $this->context->ffi->new($this->type, false);
    }

    public function isInitialized(): bool
    {
        return $this->initialized;
    }

    public function get(): CData
    {
        // @phpstan-ignore-next-line
        ($this->context->vt->{'get_' . $this->name})(
            $this->context->cdata,
            \FFI::addr($this->value),
        );

        $this->initialized = true;

        return $this->value;
    }

    public function set(mixed $value): void
    {
        ($this->context->vt->{'put_' . $this->name})(
            $this->context->cdata,
            $value,
        );
    }

    public function __destruct()
    {
        \FFI::free(\FFI::addr($this->value));
    }
}
