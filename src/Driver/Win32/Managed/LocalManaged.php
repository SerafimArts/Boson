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

    /**
     * @param non-empty-string $name
     * @param array<non-empty-string, mixed> $args
     */
    protected function call(string $name, array $args): mixed
    {
        $method = $this->method($name);

        // @phpstan-ignore-next-line
        return $method($this->ptr, ...$args);
    }

    /**
     * @param non-empty-string $name
     */
    protected function method(string $name): CData
    {
        /**
         * @var CData
         * @phpstan-ignore-next-line
         */
        return $this->ptr->lpVtbl->$name;
    }

    /**
     * @param non-empty-string $method
     * @param array<non-empty-string, mixed> $args
     */
    public function __call(string $method, array $args = []): mixed
    {
        return $this->call($method, $args);
    }

    public function __destruct()
    {
        $this->Release();
    }
}
