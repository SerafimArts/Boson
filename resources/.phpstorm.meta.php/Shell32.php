<?php

// @formatter:off
// phpcs:ignoreFile

/**
 * A helper file for FFI, to provide autocomplete information to your IDE
 * Generated for FFI {@see Serafim\WinUI\Driver\Win32\Lib\Shell32}.
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author Nesmeyanov Kirill <nesk@xakep.ru>
 * @see https://github.com/php-ffi/ide-helper-generator
 *
 * @psalm-suppress all
 */

declare (strict_types=1);
namespace PHPSTORM_META {
    registerArgumentsSet(
        // ffi_shell32types_list
        'ffi_shell32types_list',
        'void*',
        'bool',
        'float',
        'double',
        'char',
        'int8_t',
        'uint8_t',
        'int16_t',
        'uint16_t',
        'int32_t',
        'uint32_t',
        'int64_t',
        'uint64_t',
        'CHAR',
        'WCHAR',
        'LPSTR',
        'LPWSTR',
        'HANDLE',
        'HWND',
        'DWORD',
        'LONG',
        'HRESULT',
    );
    expectedArguments(\Serafim\WinUI\Driver\Win32\Lib\Shell32::new(), 0, argumentsSet('ffi_shell32types_list'));
    expectedArguments(\Serafim\WinUI\Driver\Win32\Lib\Shell32::cast(), 0, argumentsSet('ffi_shell32types_list'));
    expectedArguments(\Serafim\WinUI\Driver\Win32\Lib\Shell32::type(), 0, argumentsSet('ffi_shell32types_list'));
    override(\Serafim\WinUI\Driver\Win32\Lib\Shell32::new(0), map([
        // List of return type coercions
        '' => '\PHPSTORM_META\@',
    ]));
}
namespace Serafim\WinUI\Driver\Win32\Lib {
    interface Shell32
    {
        /**
         * @param int<-2147483648, 2147483647> $csidl
         * @param int<0, 4294967296> $dwFlags
         * @return int<-2147483648, 2147483647>
         */
        public function SHGetFolderPathA(?\FFI\CData $hwnd, int $csidl, ?\FFI\CData $hToken, int $dwFlags, string|\FFI\CData|null $pszPath): int;
        /**
         * @param int<-2147483648, 2147483647> $csidl
         * @param int<0, 4294967296> $dwFlags
         * @return int<-2147483648, 2147483647>
         */
        public function SHGetFolderPathW(?\FFI\CData $hwnd, int $csidl, ?\FFI\CData $hToken, int $dwFlags, string|\FFI\CData|null $pszPath): int;
    }
}