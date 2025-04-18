<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer\Frontend;

use Serafim\Boson\Installer\Asset;
use Serafim\Boson\Installer\InstalledAsset;

/**
 * @template-extends InstalledAsset<Asset>
 */
final readonly class FrontendInstalledAsset extends InstalledAsset
{
    public function toArray(): array
    {
        return [
            'url' => $this->package->getDistUrl(),
            'os' => $this->asset->os->value,
            'cpu' => $this->asset->arch->value,
        ];
    }
}
