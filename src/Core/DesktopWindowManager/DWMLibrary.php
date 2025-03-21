<?php

declare(strict_types=1);

namespace Serafim\Boson\Core\DesktopWindowManager;

use FFI\Env\Runtime;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson
 */
final readonly class DWMLibrary
{
    public \FFI $ffi;

    public function __construct()
    {
        Runtime::assertAvailable();

        $this->ffi = \FFI::cdef(self::getHeaders(), 'Dwmapi.dll');
    }

    /**
     * @return non-empty-string
     */
    private static function getHeaders(): string
    {
        /** @var non-empty-string $headers */
        static $headers = \file_get_contents(__FILE__, offset: __COMPILER_HALT_OFFSET__);

        return $headers;
    }

    /**
     * @param non-empty-string $method
     * @param array<non-empty-string|int<0, max>, mixed> $args
     */
    public function __call(string $method, array $args): mixed
    {
        // @phpstan-ignore-next-line : Additional assertion
        assert($method !== '', 'Method name MUST not be empty');

        // @phpstan-ignore-next-line : Thx PHPStan, I know
        return $this->ffi->$method(...$args);
    }

    public function __serialize(): array
    {
        throw new \LogicException('Cannot serialize DesktopWindowManagerLibrary library');
    }

    public function __clone()
    {
        throw new \LogicException('Cannot clone DesktopWindowManagerLibrary library');
    }
}

__halt_compiler();

typedef void*           HWND;
typedef long            LONG;
typedef LONG            HRESULT;
typedef unsigned long   DWORD;
typedef const void*     LPCVOID;

HRESULT DwmSetWindowAttribute(
    HWND    hwnd,
    DWORD   dwAttribute,
    LPCVOID pvAttribute,
    DWORD   cbAttribute
);
