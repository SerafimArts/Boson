<?php

declare(strict_types=1);

namespace Serafim\Boson\Shared\Win32\AdvancedBaseApi;

use FFI\CData;

/**
 * @mixin \FFI
 *
 * @phpstan-type HKeyType CData
 * @phpstan-type LStatusType int<-2147483648, 2147483647>
 * @phpstan-type OptionsType int<0, 4294967295>
 * @phpstan-type DesiredType Key::*|int<0, 4294967295>
 * @phpstan-type RegDataType RegDataType::*|int<0, 4294967295>
 */
final readonly class LibAdvapi32
{
    /**
     * @param HKeyType|null $hKey
     * @param OptionsType $ulOptions
     * @param DesiredType $samDesired
     * @return LStatusType
     */
    public function RegOpenKeyExA(
        ?CData $hKey,
        string|CData $lpSubKey,
        int $ulOptions,
        int $samDesired,
        ?CData $phkResult,
    ): int {}

    /**
     * @param HKeyType|null $hKey
     * @param OptionsType $ulOptions
     * @param DesiredType $samDesired
     * @return LStatusType
     */
    public function RegOpenKeyExW(
        ?CData $hKey,
        string|CData $lpSubKey,
        int $ulOptions,
        int $samDesired,
        ?CData $phkResult,
    ): int {}

    /**
     * @param HKeyType $hKey
     * @param RegDataType $dwFlags
     * @return LStatusType
     */
    public function RegGetValueA(
        ?CData $hKey,
        string|CData|null $lpSubKey,
        string|CData|null $lpValue,
        int $dwFlags,
        mixed $pdwType,
        ?CData $pvData,
        ?CData $pcbData,
    ): int {}

    /**
     * @param HKeyType $hKey
     * @param RegDataType $dwFlags
     * @return LStatusType
     */
    public function RegGetValueW(
        ?CData $hKey,
        string|CData|null $lpSubKey,
        string|CData|null $lpValue,
        int $dwFlags,
        mixed $pdwType,
        ?CData $pvData,
        ?CData $pcbData,
    ): int {}

    /**
     * @return LStatusType
     */
    public function RegCloseKey(
        ?CData $hKey,
    ): int {}
}
