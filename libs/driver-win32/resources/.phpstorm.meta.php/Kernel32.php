<?php

// @formatter:off
// phpcs:ignoreFile

/**
 * A helper file for FFI, to provide autocomplete information to your IDE
 * Generated for FFI {@see Local\Driver\Win32\Lib\Kernel32}.
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
        // ffi_kernel32types_list
        'ffi_kernel32types_list',
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
        'LPCSTR',
        'LPCWSTR',
        'HINSTANCE',
        'HMODULE',
    );
    expectedArguments(\Local\Driver\Win32\Lib\Kernel32::new(), 0, argumentsSet('ffi_kernel32types_list'));
    expectedArguments(\Local\Driver\Win32\Lib\Kernel32::cast(), 0, argumentsSet('ffi_kernel32types_list'));
    expectedArguments(\Local\Driver\Win32\Lib\Kernel32::type(), 0, argumentsSet('ffi_kernel32types_list'));
    override(\Local\Driver\Win32\Lib\Kernel32::new(0), map([
        // List of return type coercions
        '' => '\PHPSTORM_META\@',
    ]));
}
namespace Local\Driver\Win32\Lib {
    interface Kernel32
    {
        public function GetModuleHandleA(string|\FFI\CData|null $lpModuleName): ?\FFI\CData;
        public function GetModuleHandleW(string|\FFI\CData|null $lpModuleName): ?\FFI\CData;
    }
}
