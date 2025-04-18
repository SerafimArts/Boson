<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer;

use Composer\Package\Package;
use Composer\Package\PackageInterface;

abstract class AssetPackage extends Package
{
    /**
     * Assets URL template
     */
    protected const string ASSETS_URL = 'https://github.com/SerafimArts/Boson/releases/download/%s/%s';

    abstract protected PackageInterface $package { get; }

    abstract protected Asset $asset { get; }

    /**
     * @return 'dist'
     */
    public function getInstallationSource(): string
    {
        return 'dist';
    }

    public function getDistType(): string
    {
        return 'zip';
    }

    public function getDistUrls(): array
    {
        /** @var list<non-empty-string> */
        return [$this->getDistUrl()];
    }

    /**
     * @return non-empty-string
     */
    public function getDistUrl(): string
    {
        /**
         * @var non-empty-string
         *
         * @phpstan-ignore-next-line
         */
        return \sprintf(self::ASSETS_URL, $this->getPrettyVersion(), $this->asset->name);
    }
}
