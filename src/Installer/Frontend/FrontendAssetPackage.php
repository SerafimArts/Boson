<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer\Frontend;

use Composer\Package\PackageInterface;
use Serafim\Boson\Installer\Asset;
use Serafim\Boson\Installer\AssetPackage;

final class FrontendAssetPackage extends AssetPackage
{
    public function __construct(
        protected readonly PackageInterface $package,
        protected readonly Asset $asset,
    ) {
        parent::__construct(
            name: \vsprintf('%s[os@%s][arch@%s]', [
                $this->package->getName(),
                $this->asset->os->value,
                $this->asset->arch->value,
            ]),
            version: $this->package->getVersion(),
            prettyVersion: $this->package->getPrettyVersion(),
        );
    }
}
