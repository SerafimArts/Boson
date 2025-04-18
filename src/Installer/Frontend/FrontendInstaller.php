<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer\Frontend;

use Composer\Package\PackageInterface;
use React\Promise\PromiseInterface;
use Serafim\Boson\Environment\Architecture;
use Serafim\Boson\Environment\OperatingSystem;
use Serafim\Boson\Installer\Asset;
use Serafim\Boson\Installer\AssetsCollection;
use Serafim\Boson\Installer\Installer;

use function React\Promise\all;
use function React\Promise\reject;
use function React\Promise\resolve;

/**
 * @template-extends Installer<Asset>
 */
final readonly class FrontendInstaller extends Installer
{
    /**
     * Title for OS selection (first step)
     */
    private const string STEP_1_MESSAGE = '1) Select target OS';

    /**
     * Title for CPU architecture selection (second step)
     */
    private const string STEP_2_MESSAGE = '2) Select target CPU architecture';

    public function findAssets(PackageInterface $package): ?FrontendAssetsCollection
    {
        $config = $this->getConfig($package);

        $collection = FrontendAssetsCollection::fromArray($config['frontend'] ?? []);

        if ($collection->count() === 0) {
            return null;
        }

        return $collection;
    }

    private function getInstallationLockFile(PackageInterface $package): string
    {
        $directory = $this->getInstallPath($package);

        return $directory . '/assets.frontend.lock';
    }

    public function isInstalled(PackageInterface $package): bool
    {
        return $this->findAssets($package) === null
            || \is_file($this->getInstallationLockFile($package));
    }

    /**
     * @param iterable<array-key, FrontendInstalledAsset> $assets
     * @return PromiseInterface<iterable<array-key, FrontendInstalledAsset>>
     */
    private function writeInstalledToLock(PackageInterface $package, iterable $assets): PromiseInterface
    {
        $promises = [];
        $installed = [];

        foreach ($assets as $asset) {
            $promises[] = $asset->toArray();
        }

        $lock = $this->getInstallationLockFile($package);

        \file_put_contents($lock, \json_encode([
            'version' => $package->getPrettyVersion(),
            'assets' => $installed,
        ]));

        return all($promises);
    }

    private function skipIfNoAssetsAvailable(PackageInterface $package): bool
    {
        if (\str_starts_with($package->getPrettyVersion(), 'dev-')) {
            $this->io->alert(\sprintf(
                ' Assets for non-release version "%s" is not available ',
                $package->getPrettyVersion(),
            ));
            $this->io->alert(' Please download assets manually from expected release: ');
            $this->io->write(' See: https://github.com/SerafimArts/Boson/releases');

            return true;
        }

        return false;
    }

    public function install(PackageInterface $package, AssetsCollection $assets): PromiseInterface
    {
        $directory = $this->getInstallPath($package);

        // TITLE
        $this->io->write('');
        $this->io->write('');
        $this->io->warning(\sprintf(' Package "%s" requires additional runtime binaries ', $package->getName()));
        $this->io->write('');

        // Check availability
        if ($this->skipIfNoAssetsAvailable($package)) {
            return reject(new \RuntimeException('Installation failed'));
        }

        $assets = $this->selectTargetOperatingSystems($assets);
        $assets = $this->selectTargetArch($assets);

        $progress = $this->downloadAssets($package, $assets, $directory);

        return $this->writeInstalledToLock($package, $progress);
    }

    /**
     * @param iterable<array-key, Asset> $assets
     * @param non-empty-string $directory
     *
     * @return iterable<array-key, FrontendInstalledAsset>
     */
    private function downloadAssets(PackageInterface $package, iterable $assets, string $directory): iterable
    {
        $this->downloads->setPreferDist(true);

        $downloaded = [];

        foreach ($assets as $asset) {
            $assetPackage = new FrontendAssetPackage($package, $asset);

            if (\in_array($asset->name, $downloaded, true)) {
                yield new FrontendInstalledAsset(
                    asset: $asset,
                    package: $assetPackage,
                    progress: resolve(null),
                );
                continue;
            }

            yield new FrontendInstalledAsset(
                asset: $asset,
                package: $assetPackage,
                progress: $this->downloads->download($assetPackage, $directory)
                    ->then(fn() => $this->downloads->install($assetPackage, $directory))
                    ->catch(function (\Throwable $e): void {
                        $this->io->error($e->getMessage());
                    }),
            );

            $downloaded[] = $asset->name;
        }
    }

    /**
     * Select CPU architecture.
     *
     * Filter input {@see FrontendAssetsCollection} by the user selection option.
     */
    private function selectTargetArch(FrontendAssetsCollection $input): FrontendAssetsCollection
    {
        $selected = $this->select(
            message: self::STEP_2_MESSAGE,
            options: $input->getAvailableArchitectures(),
            default: Architecture::current(),
        );

        if ($selected === null) {
            return $input;
        }

        return $input->withArchitecture($selected);
    }

    /**
     * Select Operating System.
     *
     * Filter input {@see FrontendAssetsCollection} by the user selection option.
     */
    private function selectTargetOperatingSystems(FrontendAssetsCollection $input): FrontendAssetsCollection
    {
        $selected = $this->select(
            message: self::STEP_1_MESSAGE,
            options: $input->getAvailableOperatingSystems(),
            default: OperatingSystem::current(),
        );

        if ($selected === null) {
            return $input;
        }

        return $input->withOperatingSystem($selected);
    }
}
