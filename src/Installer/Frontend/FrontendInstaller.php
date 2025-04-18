<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer\Frontend;

use Composer\Downloader\DownloadManager;
use Composer\IO\IOInterface;
use Composer\Package\Package;
use Composer\Package\PackageInterface;
use React\Promise\PromiseInterface;
use Serafim\Boson\Installer\Asset;
use Serafim\Boson\Environment\Architecture;
use Serafim\Boson\Environment\OperatingSystem;

final readonly class FrontendInstaller
{
    /**
     * Message for selecting all options
     */
    private const string CHOICE_ANY = 'Any';

    /**
     * Message in case of selection error
     */
    private const string SELECT_ERROR = 'Please type one of [0...%d]';

    /**
     * Title for OS selection (first step)
     */
    private const string STEP_1_MESSAGE = '1) Select target OS';

    /**
     * Title for CPU architecture selection (second step)
     */
    private const string STEP_2_MESSAGE = '2) Select target CPU architecture';

    /**
     * Title for runtime (backend) selection
     */
    private const string STEP_3_MESSAGE = '3.%d) [<info>%s</info>] Select runtime';

    /**
     * Skipping notice for runtime (backend)
     */
    private const string STEP_3_SKIP_MESSAGE = '3.%d) [<info>%s</info>] Selected "<comment>%s</comment>" runtime';

    private AssetsCollection $assets;

    public function __construct(
        private IOInterface $io,
        private DownloadManager $downloadManager,
    ) {
        $this->assets = new AssetsCollection();
    }

    /**
     * @return iterable<array-key, PromiseInterface<mixed>>
     */
    public function install(PackageInterface $package, string $directory): iterable
    {
        $this->io->write('');
        $this->io->warning(\sprintf(
            ' Package "%s" requires additional runtime binaries ',
            $package->getName(),
        ));

        if (\str_starts_with($package->getPrettyVersion(), 'dev-')) {
            $this->io->alert(\sprintf(
                ' Assets for non-release version "%s" is not available ',
                $package->getPrettyVersion(),
            ));
            $this->io->alert(' Please download assets manually from expected release: ');
            $this->io->write(' See: https://github.com/SerafimArts/Boson/releases');
            return [];
        }

        $assets = $this->selectTargetOperatingSystems($this->assets);
        $assets = $this->selectTargetArch($assets);
        $assets = $this->selectTargetBackend($assets);


        foreach ($this->downloadSelectedAssets($package, $assets, $directory . '/bin') as $promise) {
            yield $promise;
        }

        return [];
    }

    /**
     * @param iterable<array-key, Asset> $assets
     * @param non-empty-string $directory
     * @return iterable<array-key, PromiseInterface<mixed>>
     */
    private function downloadSelectedAssets(PackageInterface $package, iterable $assets, string $directory): iterable
    {
        $this->downloadManager->setPreferDist(true);

        $downloaded = [];

        foreach ($assets as $asset) {
            if (\in_array($asset->name, $downloaded, true)) {
                continue;
            }

            $assetPackage = new class($package, $asset) extends Package {
                /**
                 * Assets URL template
                 */
                private const string ASSETS_URL = 'https://github.com/SerafimArts/Boson/releases/download/%s/%s';

                public function __construct(
                    private readonly PackageInterface $package,
                    private readonly Asset $asset,
                ) {
                    parent::__construct(
                        name: \vsprintf('%s@%s-%s-%s', [
                            $this->package->getName(),
                            $this->asset->os->name,
                            $this->asset->arch->name,
                            $this->asset->backend->name,
                        ]),
                        version: $this->package->getVersion(),
                        prettyVersion: $this->package->getPrettyVersion(),
                    );
                }

                /**
                 * @return 'dist'
                 */
                public function getInstallationSource(): string
                {
                    return 'dist';
                }

                public function getDistType(): string
                {
                    return 'zip';
                }

                public function getDistUrls(): array
                {
                    /** @var list<non-empty-string> */
                    return [$this->getDistUrl()];
                }

                /**
                 * @return non-empty-string
                 */
                public function getDistUrl(): string
                {
                    /**
                     * @var non-empty-string
                     * @phpstan-ignore-next-line
                     */
                    return \sprintf(self::ASSETS_URL, $this->getPrettyVersion(), $this->asset->name);
                }
            };

            yield $this->downloadManager->download($assetPackage, $directory)
                ->then(fn() => $this->downloadManager->install($assetPackage, $directory))
                ->catch(function (\Throwable $e): void {
                    $this->io->error($e->getMessage());
                })
            ;

            $downloaded[] = $asset->name;
        }
    }

    /**
     * Select runtime (backend).
     *
     * Filter input {@see AssetsCollection} by the user selection option.
     */
    private function selectTargetBackend(AssetsCollection $input): AssetsCollection
    {
        $backends = [];

        foreach ($input->getAvailableOperatingSystems() as $i => $os) {
            $filtered = $input->withOperatingSystem($os);
            $available = $filtered->getAvailableBackends();

            switch (\count($available)) {
                case 0:
                    return $input;

                case 1:
                    $backends[] = $selected = $available[0];
                    $this->io->write(\vsprintf(self::STEP_3_SKIP_MESSAGE, [
                        $i + 1,
                        $os->name,
                        $selected->name,
                    ]));
                    break;

                default:
                    $selected = $this->select(
                        message: \vsprintf(self::STEP_3_MESSAGE, [
                            $i + 1,
                            $os->name,
                        ]),
                        options: $filtered->getAvailableBackends(),
                    );

                    $backends = [
                        ...$backends,
                        ...($selected === null ? $available : [$selected]),
                    ];
            }
        }

        if ($backends === []) {
            return $input;
        }

        return $input->withBackend(...$backends);
    }

    /**
     * Select CPU architecture.
     *
     * Filter input {@see AssetsCollection} by the user selection option.
     */
    private function selectTargetArch(AssetsCollection $input): AssetsCollection
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
     * Filter input {@see AssetsCollection} by the user selection option.
     */
    private function selectTargetOperatingSystems(AssetsCollection $input): AssetsCollection
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

    /**
     * @template TArgOption of \UnitEnum
     * @param list<TArgOption> $options
     * @param TArgOption|null $default
     * @return TArgOption|null
     */
    private function select(string $message, array $options, ?\UnitEnum $default = null): mixed
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

    public function uninstall(PackageInterface $package): void
    {
        // no op
    }
}
