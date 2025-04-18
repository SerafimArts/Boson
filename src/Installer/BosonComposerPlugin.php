<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer;

use Composer\Composer;
use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

final class BosonComposerPlugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io): void
    {
        $installers = $composer->getInstallationManager();
        $installers->addInstaller(new AssetsInstaller($io, $composer));

        $repositories = $composer->getRepositoryManager();
        $local = $repositories->getLocalRepository();

        foreach ($local->getPackages() as $package) {
            if (!$installers->isPackageInstalled($local, $package)) {
                $installers->install($local, new InstallOperation($package));
            }
        }
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
        // no op
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
        // no op
    }
}
