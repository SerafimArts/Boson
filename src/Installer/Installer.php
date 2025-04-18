<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer;

use Composer\Downloader\DownloadManager;
use Composer\Installer\InstallationManager;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;

/**
 * @template TAsset of Asset = Asset
 *
 * @phpstan-type ConfigType array{
 *     directory?: non-empty-string,
 *     frontend?: array<non-empty-string, array<non-empty-string, array<non-empty-string, non-empty-string>>>,
 *     backend?: array<non-empty-string, array<non-empty-string, non-empty-string>>,
 *     ...<non-empty-string, mixed>
 * }
 *
 * @template-implements InstallerInterface<TAsset>
 */
abstract readonly class Installer implements InstallerInterface
{
    /**
     * Message for selecting all options
     */
    protected const string CHOICE_ANY = 'any (all available)';

    /**
     * Message in case of selection error
     */
    protected const string SELECT_ERROR = 'Please type one of [0...%d]';

    public function __construct(
        protected IOInterface $io,
        protected DownloadManager $downloads,
    ) {}

    /**
     * @return ConfigType
     */
    protected function getConfig(PackageInterface $package): array
    {
        $extra = $package->getExtra();

        /** @var ConfigType */
        return $extra['boson'] ?? [];
    }

    /**
     * @return non-empty-string
     */
    protected function getInstallPath(PackageInterface $package): string
    {
        $directory = $this->installs->getInstallPath($package);
        $directory = \rtrim($directory, '/\\');

        $config = $this->getConfig($package);
        $suffix = \trim($config['directory'] ?? '', '/\\');

        if ($suffix === '') {
            return $directory;
        }

        return $directory . '/' . $suffix;
    }

    /**
     * @template TArgOption of \UnitEnum
     *
     * @param list<TArgOption> $options
     * @param TArgOption|null $default
     *
     * @return TArgOption|null
     */
    protected function select(string $message, array $options, ?\UnitEnum $default = null): mixed
    {
        if ($options === []) {
            return null;
        }

        $choices = [];
        $choice = null;

        // Cast enum options to choices list
        foreach ($options as $option) {
            $choices[] = $current = $option instanceof \BackedEnum
                ? (string) $option->value
                : $option->name;

            if ($default === $option) {
                $choice = $current;
            }
        }

        // Add "all" option
        $choice ??= self::CHOICE_ANY;
        $choices[] = self::CHOICE_ANY;

        $selected = $this->io->select(
            question: \sprintf($message . ' (default: "<comment>%s</comment>"):', $choice),
            choices: $choices,
            default: $choice,
            errorMessage: \sprintf(self::SELECT_ERROR, \array_key_last($choices)),
        );

        return $options[(int) $selected] ?? null;
    }
}
