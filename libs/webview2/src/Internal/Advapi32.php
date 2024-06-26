<?php

declare(strict_types=1);

namespace Local\WebView2\Internal;

use Local\Driver\Win32\Library;

/**
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal Local\WebView2
 */
final class Advapi32 extends Library
{
    public function __construct()
    {
        parent::__construct('Advapi32.dll');
    }

    public static function getHeader(): string
    {
        return (string) \file_get_contents(__FILE__, offset: __COMPILER_HALT_OFFSET__);
    }
}

__halt_compiler();

typedef intptr_t LONG_PTR; // "long" or "__int64"
typedef long LONG;
typedef unsigned long ULONG;
typedef unsigned long DWORD;
typedef char CHAR;
typedef void *PVOID;
typedef const CHAR *LPCSTR;
typedef const CHAR *LPCWSTR; // Wide string hack
typedef PVOID HANDLE;
typedef HANDLE HKEY;
typedef LONG LSTATUS;
typedef ULONG REGSAM;
typedef HKEY *PHKEY;

LSTATUS RegOpenKeyExA(
    HKEY hKey,
    LPCSTR lpSubKey,
    DWORD ulOptions,
    REGSAM samDesired,
    PHKEY phkResult
);

LSTATUS RegOpenKeyExW(
    HKEY hKey,
    LPCWSTR lpSubKey,
    DWORD ulOptions,
    REGSAM samDesired,
    PHKEY phkResult
);
