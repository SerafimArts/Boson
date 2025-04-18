<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer;

use Composer\Installer\BinaryInstaller;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\PartialComposer;
use Composer\Repository\InstalledRepositoryInterface;
use Composer\Util\Filesystem;
use Serafim\Boson\Installer\Frontend\FrontendInstaller;

final class AssetsInstaller extends LibraryInstaller
{
    private FrontendInstaller $installer;

    public function __construct(
        IOInterface $io,
        PartialComposer $composer,
        ?string $type = 'library',
        ?Filesystem $filesystem = null,
        ?BinaryInstaller $binaryInstaller = null,
    ) {
        parent::__construct($io, $composer, $type, $filesystem, $binaryInstaller);

        $this->installer = new FrontendInstaller($io, $this->getDownloadManager());
    }

    public function isInstalled(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        return parent::isInstalled($repo, $package)
            && $this->installer->isInstalled($package);
    }

    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        return parent::install($repo, $package)
            ->then(function () use ($package) {
                $assets = $this->installer->findAssets($package);

                if ($assets === null) {
                    return;
                }

                $this->installer->install($package, $assets);
            });
    }

    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        return parent::update($repo, $initial, $target)
            ->then(function () use ($target) {
                $assets = $this->installer->findAssets($target);

                if ($assets === null) {
                    return;
                }

                $this->installer->install($target, $assets);
            });
    }
}
