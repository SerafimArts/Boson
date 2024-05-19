<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Lib;

final readonly class CoInit
{
    /**
     * These constants are only valid on Windows NT 4.0
     *
     * OLE calls objects on any thread.
     */
    public const int COINITBASE_MULTITHREADED = 0x0;

    /**
     * Apartment model.
     */
    public const int COINIT_APARTMENTTHREADED = 0x2;

    /**
     * These constants are only valid on Windows NT 4.0
     */
    public const int COINIT_MULTITHREADED = self::COINITBASE_MULTITHREADED;

    /**
     * These constants are only valid on Windows NT 4.0
     *
     * Don't use DDE for Ole1 support.
     */
    public const int COINIT_DISABLE_OLE1DDE = 0x4;

    /**
     * These constants are only valid on Windows NT 4.0
     *
     * Trade memory for speed.
     */
    public const int COINIT_SPEED_OVER_MEMORY = 0x8;
}
