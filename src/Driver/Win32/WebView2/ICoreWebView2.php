<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;
use Serafim\WinUI\Driver\Win32\Managed\LocalCreated;
use Serafim\WinUI\Driver\Win32\Managed\ManagedStruct;
use Serafim\WinUI\Driver\Win32\Text;
use Serafim\WinUI\Property\Property;
use Serafim\WinUI\Property\PropertyProviderTrait;

/**
 * @property-read ICoreWebView2Settings $settings
 *
 * @template-extends LocalCreated<WebView2>
 */
#[ManagedStruct(name: 'ICoreWebView2')]
final class ICoreWebView2 extends LocalCreated
{
    use PropertyProviderTrait;

    public function __construct(
        WebView2 $ffi,
        CData $ptr,
        public readonly ICoreWebView2Controller $host,
    ) {
        parent::__construct($ffi, $ptr);
    }

    /**
     * @api
     */
    public function navigate(string $url): void
    {
        $this->call('Navigate', [Text::wide($url)]);
    }

    /**
     * @api
     * @return Property<ICoreWebView2Settings, never>
     */
    protected function settings(): Property
    {
        return Property::getter(function () {
            $settings = ICoreWebView2Settings::allocate($this->ffi);

            $result = $this->get_Settings(\FFI::addr($settings));

            if ($result !== 0) {
                throw new \RuntimeException('Could not get WebView settings');
            }

            return new ICoreWebView2Settings(
                ffi: $this->ffi,
                ptr: $settings,
                core: $this,
            );
        });
    }
}
