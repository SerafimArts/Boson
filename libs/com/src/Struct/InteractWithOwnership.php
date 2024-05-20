<?php

declare(strict_types=1);

namespace Local\Com\Struct;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\Struct;

/**
 * @mixin Struct
 * @phpstan-require-extends Struct
 *
 * @property-read CData $cdata Reference to real C-struct defined in the {@see Struct} class.
 *
 * @internal This is an internal library trait, please do not use it in your code.
 */
trait InteractWithOwnership
{
    use ContainStructMetadata;

    /**
     * Explicitly specifies ownership behavior for the specified structure.
     *
     * In case the behavior is not specified (that is {@see null}), then the
     * base value specified in the {@see MapStruct} attribute is used.
     */
    private ?bool $isOwnedStruct = null;

    /**
     * @internal This is an internal library method, please do not use it in your code.
     * @private
     */
    public function markAsNonOwned(): void
    {
        $this->isOwnedStruct = false;
    }

    /**
     * @internal This is an internal library method, please do not use it in your code.
     * @private
     */
    public function markAsOwned(): void
    {
        $this->isOwnedStruct = true;
    }

    protected function tearDownInteractWithOwnership(): void
    {
        $metadata = self::getStructMetadata();

        // In the case that manual control of the structure's memory is
        // disabled, the PHP GC itself will clear the memory for it.
        if ($this->isOwnedStruct ?? $metadata->isOwned) {
            return;
        }

        // Freeing the memory of the attached structure.
        \FFI::free(\FFI::addr($this->cdata));
    }
}
