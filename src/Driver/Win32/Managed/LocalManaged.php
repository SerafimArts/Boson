<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Managed;

use FFI\CData;

/**
 * @method int AddRef()
 * @method int Release()
 * @method int QueryInterface(CData $iid, CData $object)
 */
abstract class LocalManaged
{
    public function __construct(
        public readonly CData $ptr,
    ) {
        $this->AddRef();
    }

    protected function call(string $name, array $args): mixed
    {
        $method = $this->method($name);

        return $method($this->ptr, ...$args);
    }

    protected function method(string $name): CData
    {
        /** @var CData */
        return $this->ptr->lpVtbl->$name;
    }

    public function __call(string $method, array $args = []): mixed
    {
        return $this->call($method, $args);
    }

    public function __destruct()
    {
        $this->Release();
    }
}
