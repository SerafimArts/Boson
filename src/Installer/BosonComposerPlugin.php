<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

final readonly class BosonComposerPlugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->addBinaryInstaller($composer, $io);
    }

    private function addBinaryInstaller(Composer $composer, IOInterface $io): void
    {
        $manager = $composer->getInstallationManager();

        $manager->addInstaller(new BosonInstaller($io, $composer));
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
