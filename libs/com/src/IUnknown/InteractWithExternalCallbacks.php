<?php

declare(strict_types=1);

namespace Local\Com\IUnknown;

use FFI\CData;
use Local\Com\IUnknown;

/**
 * @mixin IUnknown
 * @phpstan-require-extends IUnknown
 */
trait InteractWithExternalCallbacks
{
    /**
     * Contains the number of references to the external object.
     *
     * @var int<0, max>
     */
    private int $externalRefCount = 0;

    /**
     * Contains {@see true} if the structure was initialized with
     * the "AddRef" and "Release" functions.
     */
    protected bool $isExternalManagedStruct = false;

    protected function setUpInteractWithExternalCallbacks(CData $cdata): void
    {
        // In the case that the reference to AddRef proc has been initialized,
        // then we indicate that the current PHP object contains another link.
        //
        // In most cases, the presence of this proc means that the CData object
        // was obtained from within the COM library.
        $this->isExternalManagedStruct = $cdata->lpVtbl->AddRef !== null;

        if ($this->isExternalManagedStruct) {
            $this->externalRefCount = ($cdata->lpVtbl->AddRef)($cdata);
        }
    }

    protected function tearDownInteractWithExternalCallbacks(CData $cdata): void
    {
        if ($this->isExternalManagedStruct === false) {
            $this->externalRefCount = 0;
            return;
        }

        $this->externalRefCount = ($cdata->lpVtbl->AddRef)($cdata);
    }
}
