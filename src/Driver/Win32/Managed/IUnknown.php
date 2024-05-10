<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Managed;

use FFI\CData;
use Serafim\WinUI\Memory\RefHolder;

/**
 * @link https://learn.microsoft.com/en-us/office/client-developer/outlook/mapi/implementing-iunknown-in-c-plus-plus
 */
#[ManagedStruct(name: 'IUnknown')]
abstract class IUnknown extends ExternalManaged
{
    private int $refcount = 0;

    #[ManagedFunction(name: 'QueryInterface')]
    protected function query(CData $self, CData $iid, CData $object): int
    {
        return 0;
    }

    #[ManagedFunction(name: 'AddRef')]
    protected function addRef(CData $self): int
    {
        ++$this->refcount;

        RefHolder::capture($this);

        return $this->refcount;
    }

    #[ManagedFunction(name: 'Release')]
    protected function release(CData $self): int
    {
        --$this->refcount;

        if ($this->refcount === 0) {
            RefHolder::release($this);
        }

        return $this->refcount;
    }
}
