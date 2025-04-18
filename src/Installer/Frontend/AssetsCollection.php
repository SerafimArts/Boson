<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer\Frontend;

use Serafim\Boson\Environment\Architecture as Arch;
use Serafim\Boson\Environment\OperatingSystem as OS;
use Serafim\Boson\Installer\Asset;

/**
 * @template-implements \IteratorAggregate<array-key, Asset>
 */
final class AssetsCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var list<Asset>
     */
    private array $assets;

    /**
     * @param iterable<array-key, Asset> $assets
     */
    public function __construct(
        iterable $assets = [
            // Linux/QT5
            new Asset(Arch::Arm64, OS::Linux, Runtime::Qt5, 'Linux-Qt5-aarch64.zip'),
            new Asset(Arch::Amd64, OS::Linux, Runtime::Qt5, 'Linux-Qt5-x86_64.zip'),
            new Asset(Arch::x86, OS::Linux, Runtime::Qt5, 'Linux-Qt5-x86_64.zip'),
            new Asset(Arch::Arm, OS::Linux, Runtime::Qt5, 'Linux-Qt5-arm.zip'),
            // Linux/QT6
            new Asset(Arch::Arm64, OS::Linux, Runtime::Qt6, 'Linux-Qt6-aarch64.zip'),
            new Asset(Arch::Amd64, OS::Linux, Runtime::Qt6, 'Linux-Qt6-x86_64.zip'),
            new Asset(Arch::x86, OS::Linux, Runtime::Qt6, 'Linux-Qt6-x86_64.zip'),
            new Asset(Arch::Arm, OS::Linux, Runtime::Qt6, 'Linux-Qt6-arm.zip'),
            // Linux/GTK
            new Asset(Arch::Arm64, OS::Linux, Runtime::Gtk4, 'Linux-WebKitGtk-aarch64.zip'),
            new Asset(Arch::Amd64, OS::Linux, Runtime::Gtk4, 'Linux-WebKitGtk-x86_64.zip'),
            new Asset(Arch::x86, OS::Linux, Runtime::Gtk4, 'Linux-WebKitGtk-x86_64.zip'),
            new Asset(Arch::Arm, OS::Linux, Runtime::Gtk4, 'Linux-WebKitGtk-arm.zip'),
            // MacOS/WebKit
            new Asset(Arch::Arm64, OS::MacOS, Runtime::WebKit, 'MacOS-WebKit-Universal.zip'),
            new Asset(Arch::Amd64, OS::MacOS, Runtime::WebKit, 'MacOS-WebKit-Universal.zip'),
            new Asset(Arch::x86, OS::MacOS, Runtime::WebKit, 'MacOS-WebKit-Universal.zip'),
            // Windows/WebView2
            new Asset(Arch::Amd64, OS::Windows, Runtime::WebView2, 'Windows-WebView2-x86_64.zip'),
            new Asset(Arch::x86, OS::Windows, Runtime::WebView2, 'Windows-WebView2-x86_64.zip'),
        ],
    ) {
        $this->assets = \iterator_to_array($assets, false);
    }

    /**
     * @return list<Arch>
     */
    public function getAvailableArchitectures(): array
    {
        return $this->uniq(fn(Asset $asset): Arch => $asset->arch);
    }

    public function withArchitecture(Arch ...$arch): self
    {
        return $this->only(function () use ($arch): iterable {
            foreach ($this->assets as $asset) {
                if (\in_array($asset->arch, $arch, true)) {
                    yield $asset;
                }
            }
        });
    }

    /**
     * @return list<OS>
     */
    public function getAvailableOperatingSystems(): array
    {
        return $this->uniq(fn(Asset $asset): OS => $asset->os);
    }

    public function withOperatingSystem(OS ...$os): self
    {
        return $this->only(function () use ($os): iterable {
            foreach ($this->assets as $asset) {
                if (\in_array($asset->os, $os, true)) {
                    yield $asset;
                }
            }
        });
    }

    /**
     * @return list<Runtime>
     */
    public function getAvailableBackends(): array
    {
        return $this->uniq(fn(Asset $asset): Runtime => $asset->backend);
    }

    public function withBackend(Runtime ...$backend): self
    {
        return $this->only(function () use ($backend): iterable {
            foreach ($this->assets as $asset) {
                if (\in_array($asset->backend, $backend, true)) {
                    yield $asset;
                }
            }
        });
    }

    /**
     * @return list<non-empty-string>
     */
    public function getAvailableNames(string $prefix = ''): array
    {
        return $this->uniq(fn(Asset $asset): string => $prefix . $asset->name);
    }

    /**
     * @template TArgResult of mixed
     *
     * @param callable(Asset):TArgResult $callback
     *
     * @return list<TArgResult>
     */
    private function uniq(callable $callback): array
    {
        $result = [];

        foreach ($this->assets as $asset) {
            if (!\in_array($callback($asset), $result, true)) {
                $result[] = $callback($asset);
            }
        }

        return $result;
    }

    /**
     * @param callable():(iterable<array-key, Asset>) $filter
     */
    private function only(callable $filter): self
    {
        return new self($filter());
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->assets);
    }

    public function count(): int
    {
        return \count($this->assets);
    }
}
