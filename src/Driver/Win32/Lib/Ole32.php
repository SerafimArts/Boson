<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Lib;

use Serafim\WinUI\Driver\Library;

final class Ole32 extends Library
{
    public function __construct()
    {
        parent::__construct('Ole32.dll');
    }

    public static function getHeader(): string
    {
        return (string) \file_get_contents(__FILE__, offset: __COMPILER_HALT_OFFSET__);
    }
}

__halt_compiler();

typedef void *LPVOID;
typedef unsigned long DWORD;
typedef long LONG;
typedef LONG HRESULT;

HRESULT CoInitializeEx(LPVOID pvReserved, DWORD dwCoInit);
void CoUninitialize(void);
