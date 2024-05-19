<?php

declare(strict_types=1);

namespace Local\Com\IUnknown;

use FFI\CData;
use Local\Com\Attribute\MapCallback;
use Local\Com\IUnknown;

/**
 * @mixin IUnknown
 * @phpstan-require-extends IUnknown
 */
trait InteractWithLocalCallbacks
{
    /**
     * Contains the number of external references to the local PHP object.
     *
     * @var int<0, max>
     */
    private int $localRefCount = 0;

    /**
     * @api
     */
    #[MapCallback(name: 'QueryInterface')]
    protected function onQueryInterface(CData $self, CData $iid, CData $object): int
    {
        return 0;
    }

    /**
     * @api
     */
    #[MapCallback(name: 'AddRef')]
    protected function onAddRef(CData $self): int
    {
        ++$this->localRefCount;

        RefHolder::capture($this);

        return $this->localRefCount;
    }

    /**
     * @api
     */
    #[MapCallback(name: 'Release')]
    protected function onRelease(CData $self): int
    {
        --$this->localRefCount;

        if ($this->localRefCount <= 0) {
            RefHolder::release($this);
            $this->localRefCount = 0;
        }

        return $this->localRefCount;
    }
}
