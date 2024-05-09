<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Lib;

use FFI\CData;

enum Icon: int
{
    case IDI_APPLICATION = 32512;
    case IDI_HAND = 32513;
    case IDI_QUESTION = 32514;
    case IDI_EXCLAMATION = 32515;
    case IDI_ASTERISK = 32516;
    case IDI_WINLOGO = 32517;
    case IDI_SHIELD = 32518;

    public const Icon IDI_WARNING = self::IDI_EXCLAMATION;
    public const Icon IDI_ERROR = self::IDI_HAND;
    public const Icon IDI_INFORMATION = self::IDI_ASTERISK;

    public function toCData(?User32 $user32 = null): CData
    {
        $user32 ??= User32::getInstance();

        /** @var CData */
        return $user32->cast('HICON', $this->value);
    }
}
