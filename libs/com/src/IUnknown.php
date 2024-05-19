<?php

declare(strict_types=1);

namespace Local\Com;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\IUnknown\InteractWithExternalCallbacks;
use Local\Com\IUnknown\InteractWithLocalCallbacks;

/**
 * Enables clients to get pointers to other interfaces on a given object through
 * the "QueryInterface" method, and manage the existence of the object through
 * the "AddRef" and "Release" methods. All other COM interfaces are inherited,
 * directly or indirectly, from {@see IUnknown}. Therefore, the three methods
 * in {@see IUnknown} are the first entries in the vtable for every interface.
 *
 * @link https://learn.microsoft.com/en-us/windows/win32/api/unknwn/nn-unknwn-iunknown
 *
 * @template T of object
 * @template-extends Struct<T>
 */
#[MapStruct('IUnknown')]
class IUnknown extends Struct
{
    use InteractWithLocalCallbacks;
    use InteractWithExternalCallbacks;

    public function __construct(object $ffi, CData $cdata)
    {
        $this->setUpInteractWithExternalCallbacks($cdata);

        parent::__construct($ffi, $cdata);
    }

    public function __destruct()
    {
        $this->tearDownInteractWithExternalCallbacks($this->cdata);

        parent::__destruct();
    }
}
