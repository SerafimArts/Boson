<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Size\Managed;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson\Window
 */
abstract class MemoizedManagedSize extends ManagedSize
{
    /**
     * @var int<0, 2147483647>
     */
    public int $width {
        get => $this->width ??= parent::$width::get();
        set {
            parent::$width::set($this->width = $value);
        }
    }

    /**
     * @var int<0, 2147483647>
     */
    public int $height {
        get => $this->height ??= parent::$height::get();
        set {
            parent::$height::set($this->height = $value);
        }
    }
}
