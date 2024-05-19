<?php

declare(strict_types=1);

namespace Local\Com\Struct;

use FFI\CData;
use Local\Com\Struct;

/**
 * @mixin Struct
 * @phpstan-require-extends Struct
 *
 * @property-read CData $vt Reference to real C-struct defined in the {@see Struct} class.
 *
 * @internal This is an internal library trait, please do not use it in your code.
 */
trait InteractWithCallbacks
{
    use ContainStructMetadata;

    /**
     * @var int<0, max>
     */
    private int $bootedCallbacksCount = 0;

    /**
     * Triggers the initialization of callback methods once.
     */
    protected function setUpInteractWithCallbacks(): void
    {
        if ($this->bootedCallbacksCount !== 0) {
            return;
        }

        $this->attachCallbacks();
    }

    /**
     * Attaches all callback methods to their implementations.
     */
    private function attachCallbacks(): void
    {
        $metadata = static::getStructMetadata();

        foreach ($metadata->callbacks as $method => $callback) {
            $name = $callback->name;

            // @phpstan-ignore-next-line
            if ($this->vt->{$name} === null) {
                $this->vt->{$name} = $this->{$method}(...);

                ++$this->bootedCallbacksCount;
            }
        }
    }
}
