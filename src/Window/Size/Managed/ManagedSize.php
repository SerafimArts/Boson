<?php

declare(strict_types=1);

namespace Serafim\Boson\Window\Size\Managed;

use FFI\CData;
use Serafim\Boson\Shared\Saucer\LibSaucer;
use Serafim\Boson\Window\Size\MutableSizeInterface;
use Serafim\Boson\Window\Size\SizeStringableProvider;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\Boson\Window
 */
abstract class ManagedSize implements MutableSizeInterface
{
    use SizeStringableProvider;

    /**
     * @var int<0, 2147483647>
     */
    public int $width {
        get {
            $this->syncSizeValues();

            return $this->unmanagedWidthValue->cdata;
        }
        set {
            $this->update(width: $value);
        }
    }

    private readonly CData $unmanagedWidthValue;

    /**
     * @var int<0, 2147483647>
     */
    public int $height {
        get {
            $this->syncSizeValues();

            return $this->unmanagedHeightValue->cdata;
        }
        set {
            $this->update(height: $value);
        }
    }

    private readonly CData $unmanagedHeightValue;

    public function __construct(
        protected readonly LibSaucer $api,
        protected readonly CData $handle,
    ) {
        $this->unmanagedWidthValue = $this->api->new('int');
        $this->unmanagedHeightValue = $this->api->new('int');
    }

    protected function syncSizeValues(): void
    {
        $this->getCurrentSizeValuesByRef(
            width: \FFI::addr($this->unmanagedWidthValue),
            height: \FFI::addr($this->unmanagedHeightValue),
        );
    }

    abstract protected function getCurrentSizeValuesByRef(CData $width, CData $height): void;

    public function update(?int $width = null, ?int $height = null): void
    {
        if ($width === null && $height === null) {
            return;
        }

        $this->setSizeValues(
            width: $width ?? $this->width,
            height: $height ?? $this->height,
        );
    }

    /**
     * @param int<0, 2147483647> $width
     * @param int<0, 2147483647> $height
     */
    abstract protected function setSizeValues(int $width, int $height): void;
}
