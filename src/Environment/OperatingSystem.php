<?php

declare(strict_types=1);

namespace Serafim\Boson\Environment;

enum OperatingSystem
{
    case Windows;
    case Linux;
    case MacOS;
    case Unknown;

    public static function current(): self
    {
        static $current = match (\PHP_OS_FAMILY) {
            'Windows' => self::Windows,
            'Linux' => self::Linux,
            'Darwin' => self::MacOS,
            default => self::Unknown,
        };

        return $current;
    }
}
