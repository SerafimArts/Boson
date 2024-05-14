<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Managed;

/**
 * @template T of object
 * @template-extends LocalManaged<T>
 */
abstract class LocalCreated extends LocalManaged
{
    public function __destruct()
    {
        parent::__destruct();

        \FFI::free(\FFI::addr($this->ptr));
    }
}
