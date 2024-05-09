<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Lib;

use FFI\CData;

enum HKey: int
{
    case HKEY_CLASSES_ROOT = 0xFFFFFFFF << 32 | 0x80000000;
    case HKEY_CURRENT_USER = 0xFFFFFFFF << 32 | 0x80000001;
    case HKEY_LOCAL_MACHINE = 0xFFFFFFFF << 32 | 0x80000002;
    case HKEY_USERS = 0xFFFFFFFF << 32 | 0x80000003;
    case HKEY_PERFORMANCE_DATA = 0xFFFFFFFF << 32 | 0x80000004;
    case HKEY_PERFORMANCE_TEXT = 0xFFFFFFFF << 32 | 0x80000050;
    case HKEY_PERFORMANCE_NLSTEXT = 0xFFFFFFFF << 32 | 0x80000060;

    public function toCData(?Advapi32 $advapi32 = null): CData
    {
        $advapi32 ??= Advapi32::getInstance();

        /** @var CData */
        return $advapi32->cast('HKEY', $this->value);
    }
}
