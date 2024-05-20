<?php

declare(strict_types=1);

namespace Local\Com;

use FFI\CData;
use Local\Com\Struct\ContainStructMetadata;
use Local\Com\Struct\InteractWithCallbacks;
use Local\Com\Struct\InteractWithOwnership;
use Local\Property\ContainProperties;

/**
 * @template T of object
 */
abstract class Struct
{
    use ContainProperties;
    use ContainStructMetadata;
    use InteractWithOwnership;
    use InteractWithCallbacks;

    /**
     * A virtual function table is an array of pointers
     * to the methods an object supports.
     *
     * All methods of the structure are contained in it.
     *
     * ```php
     *  // Execute "foo" method
     *  $result = ($this->vt->foo)($this->cdata, ...$args);
     * ```
     */
    public readonly CData $vt;

    /**
     * @param T $ffi
     */
    public function __construct(
        public readonly object $ffi,
        public readonly CData $cdata,
    ) {
        // @phpstan-ignore-next-line
        $this->vt = $this->cdata->lpVtbl;

        $this->setUpInteractWithCallbacks();
    }

    public static function new(object $ffi, bool $owned = null): CData
    {
        $metadata = self::getStructMetadata();

        /**
         * @var CData $struct
         * @phpstan-ignore-next-line
         */
        $struct = $ffi->new($metadata->name, $owned ?? $metadata->isOwned);

        // @phpstan-ignore-next-line
        $struct->lpVtbl = $ffi->new($metadata->name . 'Vtbl', false);

        return $struct;
    }

    public function __destruct()
    {
        $this->tearDownInteractWithOwnership();
    }
}
