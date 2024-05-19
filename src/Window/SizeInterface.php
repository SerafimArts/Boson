<?php

declare(strict_types=1);

namespace Serafim\WinUI\Window;

/**
 * @property int<0, max> $width
 * @property int<0, max> $height
 */
interface SizeInterface extends SizeProviderInterface
{
    public function set(SizeProviderInterface $size): void;
}
