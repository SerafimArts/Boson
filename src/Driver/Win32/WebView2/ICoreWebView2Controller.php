<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;
use Serafim\WinUI\Driver\Win32\Managed\LocalManaged;
use Serafim\WinUI\Property\Property;
use Serafim\WinUI\Property\PropertyProviderTrait;

/**
 * @property-read ICoreWebView2 $coreWebView2
 * @property bool $isVisible
 * @property CData $bounds
 * @property float $zoomFactor
 *
 * @template-extends LocalManaged<WebView2>
 */
final class ICoreWebView2Controller extends LocalManaged
{
    use PropertyProviderTrait;

    public function __construct(
        WebView2 $ffi,
        CData $ptr,
        public readonly ICoreWebView2Environment $env,
    ) {
        parent::__construct($ffi, $ptr);
    }

    /**
     * @api
     * @return Property<bool, bool>
     */
    protected function isVisible(): Property
    {
        // @phpstan-ignore-next-line
        return $this->getManagedBoolProperty('IsVisible');
    }

    /**
     * @api
     * @return Property<CData, CData>
     */
    protected function bounds(): Property
    {
        return $this->getManagedProperty('Bounds', 'RECT');
    }

    /**
     * @api
     * @return Property<float, float>
     */
    protected function zoomFactor(): Property
    {
        return $this->getManagedScalarProperty('ZoomFactor', 'double');
    }

    /**
     * @api
     * @return Property<ICoreWebView2, never>
     */
    protected function coreWebView2(): Property
    {
        return Property::getter(function (): ICoreWebView2 {
            $webview = ICoreWebView2::allocate($this->ffi);

            $result = $this->get_CoreWebView2(\FFI::addr($webview));

            if ($result !== 0) {
                throw new \RuntimeException('Could not get WebView core');
            }

            return new ICoreWebView2(
                ffi: $this->ffi,
                ptr: $webview,
                host: $this,
            );
        });
    }

    /**
     * @api
     */
    public function close(): void
    {
        $this->call('Close');
    }

    public function __destruct()
    {
        $this->close();
    }
}
