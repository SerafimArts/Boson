<?php

// @formatter:off
// phpcs:ignoreFile

/**
 * A helper file for FFI, to provide autocomplete information to your IDE
 * Generated for FFI {@see Local\WebView2\Internal\Advapi32}.
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
        // ffi_advapi32types_list
        'ffi_advapi32types_list',
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
        'LONG_PTR',
        'LONG',
        'ULONG',
        'DWORD',
        'CHAR',
        'PVOID',
        'LPCSTR',
        'LPCWSTR',
        'HANDLE',
        'HKEY',
        'LSTATUS',
        'REGSAM',
        'PHKEY',
    );
    expectedArguments(\Local\WebView2\Internal\Advapi32::new(), 0, argumentsSet('ffi_advapi32types_list'));
    expectedArguments(\Local\WebView2\Internal\Advapi32::cast(), 0, argumentsSet('ffi_advapi32types_list'));
    expectedArguments(\Local\WebView2\Internal\Advapi32::type(), 0, argumentsSet('ffi_advapi32types_list'));
    override(\Local\WebView2\Internal\Advapi32::new(0), map([
        // List of return type coercions
        '' => '\PHPSTORM_META\@',
    ]));
}
namespace Local\WebView2\Internal {
    interface Advapi32
    {
        /**
         * @param int<0, 4294967296> $ulOptions
         * @param int<0, 4294967296> $samDesired
         * @return int<-2147483648, 2147483647>
         */
        public function RegOpenKeyExA(?\FFI\CData $hKey, string|\FFI\CData|null $lpSubKey, int $ulOptions, int $samDesired, ?\FFI\CData $phkResult): int;
        /**
         * @param int<0, 4294967296> $ulOptions
         * @param int<0, 4294967296> $samDesired
         * @return int<-2147483648, 2147483647>
         */
        public function RegOpenKeyExW(?\FFI\CData $hKey, string|\FFI\CData|null $lpSubKey, int $ulOptions, int $samDesired, ?\FFI\CData $phkResult): int;
    }
}
