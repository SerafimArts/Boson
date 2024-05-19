<?php

declare(strict_types=1);

namespace Local\Property\Attribute;

enum Access
{
    case READ;
    case WRITE;
    case BOTH;

    public function isReadable(): bool
    {
        return $this === self::READ
            || $this === self::BOTH;
    }

    public function isWritable(): bool
    {
        return $this === self::WRITE
            || $this === self::BOTH;
    }
}
