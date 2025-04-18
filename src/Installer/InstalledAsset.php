<?php

declare(strict_types=1);

namespace Serafim\Boson\Installer;

use Composer\Package\PackageInterface;
use React\Promise\PromiseInterface;

/**
 * @template TAsset of Asset
 */
abstract readonly class InstalledAsset
{
    final public function __construct(
        /**
         * @var TAsset
         */
        public Asset $asset,
        public PackageInterface $package,
        /**
         * @var PromiseInterface<mixed>
         */
        public PromiseInterface $progress,
    ) {}

    /**
     * @return array<non-empty-string, mixed>
     */
    abstract public function toArray(): array;

    /**
     * @param PromiseInterface<mixed> $promise
     * @return self<TAsset>
     */
    public function withPromise(PromiseInterface $promise): self
    {
        return new static($this->asset, $this->package, $promise);
    }
}
