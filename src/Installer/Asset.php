<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer;

use Serafim\Boson\Environment\Architecture;
use Serafim\Boson\Environment\OperatingSystem;
use Serafim\Boson\Installer\Frontend\Runtime;

final readonly class Asset
{
    public function __construct(
        /**
         * Expected architecture for this asset
         */
        public Architecture $arch,
        /**
         * Expected operating system for this asset
         */
        public OperatingSystem $os,
        /**
         * Expected backend for this asset
         */
        public Runtime $backend,
        /**
         * An asset name string
         *
         * @var non-empty-string
         */
        public string $name,
    ) {}
}
