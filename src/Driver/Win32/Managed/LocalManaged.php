<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Managed;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Managed\Reader\StructNameReader;
use Serafim\WinUI\Property\Property;

/**
 * @method int AddRef()
 * @method int Release()
 * @method int QueryInterface(CData $iid, CData $object)
 *
 * @template T of object
 */
abstract class LocalManaged
{
    private static ?StructNameReader $nameReader = null;

    /**
     * @var array<non-empty-string, CData & callable>
     */
    private array $proc = [];

    /**
     * @param T $ffi
     */
    public function __construct(
        public readonly object $ffi,
        public readonly CData $ptr,
    ) {
        $this->AddRef();
    }

    /**
     * @param non-empty-string $name
     * @return CData & callable
     */
    protected function getProc(string $name): CData
    {
        // @phpstan-ignore-next-line
        return $this->proc[$name] ??= $this->ptr->lpVtbl->$name;
    }

    /**
     * @param non-empty-string $method
     * @param non-empty-string $type
     */
    protected function getManagedPropertyValue(string $method, string $type): CData
    {
        // @phpstan-ignore-next-line
        $result = $this->ffi->new($type);

        assert($result !== null);

        $proc = $this->getProc('get_' . $method);
        $proc($this->ptr, \FFI::addr($result));

        return $result;
    }

    /**
     * @param non-empty-string $method
     */
    protected function setManagedPropertyValue(string $method, mixed $value): void
    {
        $proc = $this->getProc('put_' . $method);
        $proc($this->ptr, $value);
    }

    /**
     * @param non-empty-string $method
     * @param non-empty-string $type
     * @return Property<CData, CData>
     */
    protected function getManagedProperty(string $method, string $type): Property
    {
        return Property::new(
            get: fn(): CData => $this->getManagedPropertyValue($method, $type),
            set: fn(CData $value): null => $this->setManagedPropertyValue(
                method: $method,
                value: $this->ffi->cast($type, $value),
            ),
        );
    }

    /**
     * @param non-empty-string $method
     * @param non-empty-string $type
     * @return Property<mixed, mixed>
     */
    protected function getManagedScalarProperty(string $method, string $type): Property
    {
        return Property::new(
            get: fn(): mixed => $this->getManagedPropertyValue($method, $type)->cdata,
            set: fn(mixed $value): null => $this->setManagedPropertyValue($method, $value),
        );
    }

    /**
     * @param non-empty-string $method
     * @return Property<mixed, mixed>
     */
    protected function getManagedBoolProperty(string $method): Property
    {
        return Property::new(
            get: fn(): bool => (bool) $this->getManagedPropertyValue($method, 'BOOL')->cdata,
            set: fn(bool $value): null => $this->setManagedPropertyValue($method, (int) $value),
        );
    }

    private static function getStructNameReader(): StructNameReader
    {
        return self::$nameReader ??= new StructNameReader();
    }

    public static function allocate(object $ffi): CData
    {
        $structures = self::getStructNameReader();

        $name = $structures->read(static::class);

        // @phpstan-ignore-next-line
        $instance = $ffi->new($name, false);
        // @phpstan-ignore-next-line
        $instance->lpVtbl = $ffi->new($name . 'Vtbl', false);

        return \FFI::addr($instance);
    }

    /**
     * @param non-empty-string $method
     * @param array<non-empty-string, mixed> $args
     */
    protected function call(string $method, array $args = []): mixed
    {
        $proc = $this->getProc($method);

        return $proc($this->ptr, ...$args);
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
