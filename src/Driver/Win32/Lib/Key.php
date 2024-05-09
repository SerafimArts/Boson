<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Lib;

final readonly class Key
{
    private const int READ_CONTROL = 0x00020000;
    private const int STANDARD_RIGHTS_READ = self::READ_CONTROL;
    private const int STANDARD_RIGHTS_WRITE = self::READ_CONTROL;
    // private const int STANDARD_RIGHTS_EXECUTE = self::READ_CONTROL;
    private const int STANDARD_RIGHTS_ALL = 0x001F0000;

    private const int SYNCHRONIZE = 0x00100000;

    public const int KEY_QUERY_VALUE = 0x0001;
    public const int KEY_SET_VALUE = 0x0002;
    public const int KEY_CREATE_SUB_KEY = 0x0004;
    public const int KEY_ENUMERATE_SUB_KEYS = 0x0008;
    public const int KEY_NOTIFY = 0x0010;
    public const int KEY_CREATE_LINK = 0x0020;
    public const int KEY_WOW64_32KEY = 0x0200;
    public const int KEY_WOW64_64KEY = 0x0100;
    public const int KEY_WOW64_RES = 0x0300;
    public const int KEY_READ = (self::STANDARD_RIGHTS_READ
            | self::KEY_QUERY_VALUE
            | self::KEY_ENUMERATE_SUB_KEYS
            | self::KEY_NOTIFY)
        & ~self::SYNCHRONIZE;
    public const int KEY_WRITE = (self::STANDARD_RIGHTS_WRITE
            | self::KEY_SET_VALUE
            | self::KEY_CREATE_SUB_KEY)
        & ~self::SYNCHRONIZE;
    public const int KEY_EXECUTE = self::KEY_READ
        & ~self::SYNCHRONIZE;
    public const int KEY_ALL_ACCESS = (self::STANDARD_RIGHTS_ALL
            | self::KEY_QUERY_VALUE
            | self::KEY_SET_VALUE
            | self::KEY_CREATE_SUB_KEY
            | self::KEY_ENUMERATE_SUB_KEYS
            | self::KEY_NOTIFY
            | self::KEY_CREATE_LINK)
        & ~self::SYNCHRONIZE;
}
