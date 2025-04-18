<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer;

use Serafim\Boson\Environment\Architecture;
use Serafim\Boson\Environment\OperatingSystem;

readonly class Asset
{
    public function __construct(
        /**
         * An asset name string
         *
         * @var non-empty-string
         */
        public string $name,
        /**
         * Expected architecture for this asset
         */
        public Architecture $arch,
        /**
         * Expected operating system for this asset
         */
        public OperatingSystem $os,
    ) {}
}
