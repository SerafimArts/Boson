<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Lib;

use FFI\CData;

enum Cursor: int
{
    case IDC_ARROW = 32512;
    case IDC_IBEAM = 32513;
    case IDC_WAIT = 32514;
    case IDC_CROSS = 32515;
    case IDC_UPARROW = 32516;
    case IDC_SIZE = 32640;
    case IDC_ICON = 32641;
    case IDC_SIZENWSE = 32642;
    case IDC_SIZENESW = 32643;
    case IDC_SIZEWE = 32644;
    case IDC_SIZENS = 32645;
    case IDC_SIZEALL = 32646;
    case IDC_NO = 32648;
    case IDC_HAND = 32649;
    case IDC_APPSTARTING = 32650;
    case IDC_HELP = 32651;
    case IDC_PIN = 32671;
    case IDC_PERSON = 32672;

    public function toCData(?User32 $user32 = null): CData
    {
        $user32 ??= User32::getInstance();

        /** @var CData */
        return $user32->cast('HCURSOR', $this->value);
    }
}
