<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Size;

final readonly class Size implements SizeInterface
{
    use SizeStringableProvider;

    public function __construct(
        /**
         * @var int<0, max>
         */
        public int $width = 0,
        /**
         * @var int<0, max>
         */
        public int $height = 0,
    ) {}
}
