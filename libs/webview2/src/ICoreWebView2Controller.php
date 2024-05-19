<?php

declare(strict_types=1);

namespace Local\WebView2;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\IUnknown;
use Local\Com\Property\BoolProperty;
use Local\Com\Property\DoubleProperty;
use Local\Com\Property\Property;
use Local\Com\Property\ReadableStructProperty;
use Local\Property\Attribute\MapGetter;
use Local\Property\Attribute\MapSetter;

/**
 * @template-extends IUnknown<WebView2>
 *
 * @property CData $bounds
 * @property int<0, max> $width
 * @property int<0, max> $height
 * @property bool $isVisible
 * @property float $zoomFactor
 * @property-read ICoreWebView2 $coreWebView2
 */
#[MapStruct(name: 'ICoreWebView2Controller')]
final class ICoreWebView2Controller extends IUnknown
{
    /**
     * @var Property<CData, CData>
     */
    protected readonly Property $boundsProperty;

    protected readonly BoolProperty $isVisibleProperty;

    protected readonly DoubleProperty $zoomFactorProperty;

    /**
     * @var ReadableStructProperty<ICoreWebView2>
     */
    protected readonly ReadableStructProperty $coreWebView2Property;

    public function __construct(
        WebView2 $ffi,
        CData $cdata,
        public readonly ICoreWebView2Environment $env,
    ) {
        parent::__construct($ffi, $cdata);

        $this->boundsProperty = new Property($this, 'Bounds', 'RECT');
        $this->isVisibleProperty = new BoolProperty($this, 'IsVisible');
        $this->zoomFactorProperty = new DoubleProperty($this, 'ZoomFactor');
        $this->coreWebView2Property = new ReadableStructProperty(
            context: $this,
            name: 'CoreWebView2',
            struct: ICoreWebView2::class,
            initializer: function (CData $struct): ICoreWebView2 {
                return new ICoreWebView2($this->ffi, $struct, $this);
            },
        );
    }

    /**
     * Gets the {@see ICoreWebView2} associated with this {@see ICoreWebView2Controller}.
     *
     * @api
     */
    #[MapGetter(name: 'coreWebView2')]
    public function getCoreWebView2(): ICoreWebView2
    {
        return $this->coreWebView2Property->get();
    }

    /**
     * Returns the WebView bounds.
     *
     * The values of bounds are limited by the coordinate space of the host.
     *
     * @api
     * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2controller#get_bounds
     */
    #[MapGetter('bounds')]
    public function getBounds(): CData
    {
        return $this->boundsProperty->get();
    }

    /**
     * Sets the WebView bounds property.
     *
     * @api
     * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2controller#put_bounds
     */
    #[MapSetter('bounds')]
    public function setBounds(CData $rect): void
    {
        /** @var CData $rect */
        $rect = $this->ffi->cast('RECT', $rect);

        $this->boundsProperty->set($rect);
    }

    /**
     * Width getter mapped to {@see self::getBounds()} method.
     *
     * @return int<0, max>
     */
    #[MapGetter('width')]
    public function getWidth(): int
    {
        /** @var CData & object{right:int} $rect */
        $rect = $this->boundsProperty->get();

        return \max(0, $rect->right);
    }

    /**
     * Width setter mapped to {@see self::setBounds()} method.
     *
     * @param int<0, max> $width
     */
    #[MapSetter('width')]
    public function setWidth(int $width): void
    {
        $rect = $this->boundsProperty->isInitialized()
            ? $this->boundsProperty->value
            : $this->boundsProperty->get();

        $rect->right = $width;
        $this->boundsProperty->set($rect);
    }

    /**
     * Height getter mapped to {@see self::getBounds()} method.
     *
     * @return int<0, max>
     */
    #[MapGetter('height')]
    public function getHeight(): int
    {
        /** @var CData & object{bottom:int} $rect */
        $rect = $this->boundsProperty->get();

        return \max(0, $rect->bottom);
    }

    /**
     * Height setter mapped to {@see self::setBounds()} method.
     *
     * @param int<0, max> $height
     */
    #[MapSetter('height')]
    public function setHeight(int $height): void
    {
        $rect = $this->boundsProperty->isInitialized()
            ? $this->boundsProperty->value
            : $this->boundsProperty->get();

        $rect->bottom = $height;
        $this->boundsProperty->set($rect);
    }

    /**
     * Determines whether to show or hide the WebView2.
     *
     * If value is set to {@see false}, the WebView2 is transparent and
     * is not rendered.
     *
     * @api
     * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2controller#get_isvisible
     */
    #[MapGetter(name: 'isVisible')]
    public function getIsVisible(): bool
    {
        return $this->isVisibleProperty->get();
    }

    /**
     * Sets the value.
     *
     * @api
     * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2controller#put_isvisible
     */
    #[MapSetter(name: 'isVisible')]
    public function setIsVisible(bool $value): void
    {
        $this->isVisibleProperty->set($value);
    }

    /**
     * Returns the zoom factor for the WebView.
     *
     * @api
     * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2controller#get_zoomfactor
     */
    #[MapGetter(name: 'zoomFactor')]
    public function getZoomFactor(): float
    {
        return $this->zoomFactorProperty->get();
    }

    /**
     * Sets the ZoomFactor value.
     *
     * @api
     * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2controller#put_isvisible
     */
    #[MapSetter(name: 'zoomFactor')]
    public function setZoomFactor(float $value = 1.0): void
    {
        $this->zoomFactorProperty->set($value);
    }

    /**
     * Closes the WebView and cleans up the underlying browser instance.
     *
     * @api
     * @link https://learn.microsoft.com/en-us/microsoft-edge/webview2/reference/win32/icorewebview2controller#close
     */
    public function close(): void
    {
        ($this->vt->Close)($this->cdata);
    }

    public function __destruct()
    {
        $this->close();
    }
}
