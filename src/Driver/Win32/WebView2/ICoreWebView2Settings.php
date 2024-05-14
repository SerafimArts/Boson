<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\WebView2;

use FFI\CData;
use Serafim\WinUI\Driver\Win32\Lib\WebView2;
use Serafim\WinUI\Driver\Win32\Managed\LocalCreated;
use Serafim\WinUI\Driver\Win32\Managed\ManagedStruct;
use Serafim\WinUI\Property\Property;
use Serafim\WinUI\Property\PropertyProviderTrait;

/**
 * @property bool $isScriptEnabled
 * @property bool $isWebMessageEnabled
 * @property bool $areDefaultScriptDialogsEnabled
 * @property bool $isStatusBarEnabled
 * @property bool $areDevToolsEnabled
 * @property bool $areDefaultContextMenusEnabled
 * @property bool $areHostObjectsAllowed
 * @property bool $isZoomControlEnabled
 * @property bool $isBuiltInErrorPageEnabled
 *
 * @template-extends LocalCreated<WebView2>
 */
#[ManagedStruct(name: 'ICoreWebView2Settings')]
final class ICoreWebView2Settings extends LocalCreated
{
    use PropertyProviderTrait;

    public function __construct(
        WebView2 $ffi,
        CData $ptr,
        public readonly ICoreWebView2 $core,
    ) {
        parent::__construct($ffi, $ptr);
    }

    /**
     * @api
     * @return Property<bool, bool>
     */
    protected function isScriptEnabled(): Property
    {
        // @phpstan-ignore-next-line
        return $this->getManagedBoolProperty('IsScriptEnabled');
    }

    /**
     * @api
     * @return Property<bool, bool>
     */
    protected function isWebMessageEnabled(): Property
    {
        // @phpstan-ignore-next-line
        return $this->getManagedBoolProperty('IsWebMessageEnabled');
    }

    /**
     * @api
     * @return Property<bool, bool>
     */
    protected function areDefaultScriptDialogsEnabled(): Property
    {
        // @phpstan-ignore-next-line
        return $this->getManagedBoolProperty('AreDefaultScriptDialogsEnabled');
    }

    /**
     * @api
     * @return Property<bool, bool>
     */
    protected function isStatusBarEnabled(): Property
    {
        // @phpstan-ignore-next-line
        return $this->getManagedBoolProperty('IsStatusBarEnabled');
    }

    /**
     * @api
     * @return Property<bool, bool>
     */
    protected function areDevToolsEnabled(): Property
    {
        // @phpstan-ignore-next-line
        return $this->getManagedBoolProperty('AreDevToolsEnabled');
    }

    /**
     * @api
     * @return Property<bool, bool>
     */
    protected function areDefaultContextMenusEnabled(): Property
    {
        // @phpstan-ignore-next-line
        return $this->getManagedBoolProperty('AreDefaultContextMenusEnabled');
    }

    /**
     * @api
     * @return Property<bool, bool>
     */
    protected function areHostObjectsAllowed(): Property
    {
        // @phpstan-ignore-next-line
        return $this->getManagedBoolProperty('AreHostObjectsAllowed');
    }

    /**
     * @api
     * @return Property<bool, bool>
     */
    protected function isZoomControlEnabled(): Property
    {
        // @phpstan-ignore-next-line
        return $this->getManagedBoolProperty('IsZoomControlEnabled');
    }

    /**
     * @api
     * @return Property<bool, bool>
     */
    protected function isBuiltInErrorPageEnabled(): Property
    {
        // @phpstan-ignore-next-line
        return $this->getManagedBoolProperty('IsBuiltInErrorPageEnabled');
    }
}
