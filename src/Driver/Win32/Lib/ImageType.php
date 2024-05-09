<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Lib;

/**
 * @link https://docs.microsoft.com/en-us/windows/win32/api/winuser/nf-winuser-loadimagew
 */
final readonly class ImageType
{
    public const int IMAGE_BITMAP = 0x00;
    public const int IMAGE_ICON   = 0x01;
    public const int IMAGE_CURSOR = 0x02;
}
