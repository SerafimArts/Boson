<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer;

use Composer\Installer\BinaryInstaller as ComposerBinaryInstaller;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\PartialComposer;
use Composer\Repository\InstalledRepositoryInterface;
use Composer\Util\Filesystem;
use Serafim\Boson\Installer\Frontend\FrontendInstaller;

use function React\Promise\all;

final class BosonInstaller extends LibraryInstaller
{
    /**
     * @var non-empty-string
     */
    private const string EXPECTED_PACKAGE = 'serafim/boson';

    private readonly FrontendInstaller $installer;

    public function __construct(
        IOInterface $io,
        PartialComposer $composer,
        ?string $type = 'library',
        ?Filesystem $filesystem = null,
        ?ComposerBinaryInstaller $binaryInstaller = null,
    ) {
        parent::__construct(
            io: $io,
            composer: $composer,
            type: $type,
            filesystem: $filesystem,
            binaryInstaller: $binaryInstaller,
        );

        $this->installer = new FrontendInstaller(
            io: $io,
            downloadManager: $this->getDownloadManager(),
        );
    }

    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        return parent::install($repo, $package)
            ?->then(function () use ($package): void {
                if ($package->getName() !== self::EXPECTED_PACKAGE) {
                    return;
                }

                $directory = $this->getInstallPath($package);

                all($this->installer->install($package, $directory));
            });
    }

    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        return parent::update($repo, $initial, $target)
            ?->then(function () use ($initial, $target): void {
                if ($initial->getName() !== self::EXPECTED_PACKAGE) {
                    return;
                }

                $directory = $this->getInstallPath($target);

                $this->installer->uninstall($initial);

                all($this->installer->install($target, $directory));
            });
    }

    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        return parent::uninstall($repo, $package)
            ?->then(function () use ($package): void {
                if ($package->getName() !== self::EXPECTED_PACKAGE) {
                    return;
                }

                $this->installer->uninstall($package);
            });
    }
}
