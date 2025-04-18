<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer;

use Composer\Package\PackageInterface;
use React\Promise\PromiseInterface;

/**
 * @template TAsset of Asset
 */
interface InstallerInterface
{
    /**
     * @return AssetsCollection<TAsset>|null
     */
    public function findAssets(PackageInterface $package): ?AssetsCollection;

    public function isInstalled(PackageInterface $package): bool;

    /**
     * @param AssetsCollection<TAsset> $assets
     * @return PromiseInterface<iterable<array-key, InstalledAsset<TAsset>>>
     */
    public function install(PackageInterface $package, AssetsCollection $assets): PromiseInterface;
}
