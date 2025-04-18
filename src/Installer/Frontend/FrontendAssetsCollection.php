<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer\Frontend;

use Serafim\Boson\Environment\Architecture;
use Serafim\Boson\Environment\OperatingSystem;
use Serafim\Boson\Installer\Asset;
use Serafim\Boson\Installer\AssetsCollection;

/**
 * @template-extends AssetsCollection<Asset>
 */
final class FrontendAssetsCollection extends AssetsCollection
{
    public static function fromArray(array $data): static
    {
        $result = [];

        foreach ($data as $osName => $cpus) {
            $os = OperatingSystem::tryFrom($osName);

            if ($os === null || !\is_array($cpus)) {
                continue;
            }

            foreach ($cpus as $cpuName => $assetName) {
                $cpu = Architecture::tryFrom($cpuName);

                if ($cpu === null || $assetName === '' || !\is_string($assetName)) {
                    continue;
                }

                $result[] = new Asset(
                    name: $assetName,
                    arch: $cpu,
                    os: $os,
                );
            }
        }

        return new self($result);
    }
}
