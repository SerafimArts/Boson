<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer;

use Serafim\Boson\Environment\Architecture;
use Serafim\Boson\Environment\OperatingSystem;

/**
 * @template TAsset of Asset = Asset
 * @template-implements \IteratorAggregate<array-key, TAsset>
 */
abstract class AssetsCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var list<TAsset>
     */
    protected array $assets;

    /**
     * @param iterable<array-key, TAsset> $assets
     */
    final public function __construct(iterable $assets)
    {
        $this->assets = \iterator_to_array($assets, false);
    }

    /**
     * @param array<array-key, mixed> $data
     * @return static<TAsset>
     */
    abstract public static function fromArray(array $data): static;

    /**
     * @return list<Architecture>
     */
    public function getAvailableArchitectures(): array
    {
        return $this->uniq(fn(Asset $asset): Architecture => $asset->arch);
    }

    /**
     * @api
     * @return static<TAsset>
     */
    public function withArchitecture(Architecture $architecture, Architecture ...$other): self
    {
        $all = [$architecture, ...$other];

        return $this->only(function () use ($all): iterable {
            foreach ($this->assets as $asset) {
                if (\in_array($asset->arch, $all, true)) {
                    yield $asset;
                }
            }
        });
    }

    /**
     * @return list<OperatingSystem>
     */
    public function getAvailableOperatingSystems(): array
    {
        return $this->uniq(fn(Asset $asset): OperatingSystem => $asset->os);
    }

    /**
     * @api
     * @return static<TAsset>
     */
    public function withOperatingSystem(OperatingSystem $os, OperatingSystem ...$other): static
    {
        $all = [$os, ...$other];

        return $this->only(function () use ($all): iterable {
            foreach ($this->assets as $asset) {
                if (\in_array($asset->os, $all, true)) {
                    yield $asset;
                }
            }
        });
    }

    /**
     * @api
     * @return list<non-empty-string>
     */
    public function getAvailableNames(string $prefix = ''): array
    {
        return $this->uniq(fn(Asset $asset): string => $prefix . $asset->name);
    }

    /**
     * @template TArgResult of mixed
     *
     * @param callable(TAsset):TArgResult $callback
     *
     * @return list<TArgResult>
     */
    protected function uniq(callable $callback): array
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
     * @param callable():(iterable<array-key, TAsset>) $filter
     * @return static<TAsset>
     */
    protected function only(callable $filter): static
    {
        return new static($filter());
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
