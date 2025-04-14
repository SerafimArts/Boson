<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Event;

use Serafim\Boson\Window\Window;

final class WindowResized extends WindowEvent
{
    public function __construct(
        Window $subject,
        /**
         * @var int<0, 2147483647>
         */
        public readonly int $width,
        /**
         * @var int<0, 2147483647>
         */
        public readonly int $height,
        ?int $time = null,
    ) {
        parent::__construct($subject, $time);
    }
}
