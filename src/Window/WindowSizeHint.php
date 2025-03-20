<?php

declare(strict_types=1);

namespace Serafim\Boson\Window;

enum WindowSizeHint
{
    /**
     * Width and height are default size
     */
    case Default;

    /**
     * Width and height are minimum bounds
     */
    case MinBounds;

    /**
     * Width and height are maximum bounds
     */
    case MaxBounds;

    /**
     * Window size can not be changed by a user
     */
    case Fixed;
}
