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
     * @return Property<bool, bool>
     */
    protected function isScriptEnabled(): Property
    {
        return $this->getBoolProperty('IsScriptEnabled');
    }

    /**
     * @return Property<bool, bool>
     */
    protected function isWebMessageEnabled(): Property
    {
        return $this->getBoolProperty('IsWebMessageEnabled');
    }

    /**
     * @return Property<bool, bool>
     */
    protected function areDefaultScriptDialogsEnabled(): Property
    {
        return $this->getBoolProperty('AreDefaultScriptDialogsEnabled');
    }

    /**
     * @return Property<bool, bool>
     */
    protected function isStatusBarEnabled(): Property
    {
        return $this->getBoolProperty('IsStatusBarEnabled');
    }

    /**
     * @return Property<bool, bool>
     */
    protected function areDevToolsEnabled(): Property
    {
        return $this->getBoolProperty('AreDevToolsEnabled');
    }

    /**
     * @return Property<bool, bool>
     */
    protected function areDefaultContextMenusEnabled(): Property
    {
        return $this->getBoolProperty('AreDefaultContextMenusEnabled');
    }

    /**
     * @return Property<bool, bool>
     */
    protected function areHostObjectsAllowed(): Property
    {
        return $this->getBoolProperty('AreHostObjectsAllowed');
    }

    /**
     * @return Property<bool, bool>
     */
    protected function isZoomControlEnabled(): Property
    {
        return $this->getBoolProperty('IsZoomControlEnabled');
    }

    /**
     * @return Property<bool, bool>
     */
    protected function isBuiltInErrorPageEnabled(): Property
    {
        return $this->getBoolProperty('IsBuiltInErrorPageEnabled');
    }
}
