<?php

declare(strict_types=1);

namespace Local\WebView2\Internal;

use Local\Driver\Win32\Library;

/**
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal Local\WebView2
 */
final class Shlwapi extends Library
{
    public function __construct()
    {
        parent::__construct('Shlwapi.dll');
    }

    public static function getHeader(): string
    {
        return (string) \file_get_contents(__FILE__, offset: __COMPILER_HALT_OFFSET__);
    }
}

__halt_compiler();

typedef unsigned long DWORD;
typedef char CHAR;
typedef const CHAR *LPCSTR;
typedef const CHAR *LPCWSTR; // Wide string hack
typedef int LONG;
typedef LONG HRESULT;

typedef struct IStream IStream;

HRESULT SHCreateStreamOnFileA(
    LPCSTR pszFile,
    DWORD grfMode,
    IStream **ppstm
);

HRESULT SHCreateStreamOnFileW(
    LPCWSTR pszFile,
    DWORD grfMode,
    IStream **ppstm
);
