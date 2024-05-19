<?php

declare(strict_types=1);

namespace Local\WebView2;

use FFI\CData;
use Local\Com\Attribute\MapStruct;
use Local\Com\IUnknown;
use Local\Com\Property\BoolProperty;
use Local\Property\Attribute\MapGetter;
use Local\Property\Attribute\MapSetter;

/**
 * @template-extends IUnknown<WebView2>
 *
 * @property bool $isScriptEnabled
 * @property bool $isWebMessageEnabled
 * @property bool $areDefaultScriptDialogsEnabled
 * @property bool $isStatusBarEnabled
 * @property bool $areDevToolsEnabled
 * @property bool $areDefaultContextMenusEnabled
 * @property bool $areHostObjectsAllowed
 * @property bool $isZoomControlEnabled
 * @property bool $isBuiltInErrorPageEnabled
 */
#[MapStruct(name: 'ICoreWebView2Settings', owned: false)]
final class ICoreWebView2Settings extends IUnknown
{
    private readonly BoolProperty $isScriptEnabledProperty;
    private readonly BoolProperty $isWebMessageEnabledProperty;
    private readonly BoolProperty $areDefaultScriptDialogsEnabledProperty;
    private readonly BoolProperty $isStatusBarEnabledProperty;
    private readonly BoolProperty $areDevToolsEnabledProperty;
    private readonly BoolProperty $areDefaultContextMenusEnabledProperty;
    private readonly BoolProperty $areHostObjectsAllowedProperty;
    private readonly BoolProperty $isZoomControlEnabledProperty;
    private readonly BoolProperty $isBuiltInErrorPageEnabledProperty;

    public function __construct(
        WebView2 $ffi,
        CData $cdata,
        public readonly ICoreWebView2 $core,
    ) {
        parent::__construct($ffi, $cdata);

        $this->isScriptEnabledProperty = new BoolProperty($this, 'IsScriptEnabled');
        $this->isWebMessageEnabledProperty = new BoolProperty($this, 'IsWebMessageEnabled');
        $this->areDefaultScriptDialogsEnabledProperty = new BoolProperty($this, 'AreDefaultScriptDialogsEnabled');
        $this->isStatusBarEnabledProperty = new BoolProperty($this, 'IsStatusBarEnabled');
        $this->areDevToolsEnabledProperty = new BoolProperty($this, 'AreDevToolsEnabled');
        $this->areDefaultContextMenusEnabledProperty = new BoolProperty($this, 'AreDefaultContextMenusEnabled');
        $this->areHostObjectsAllowedProperty = new BoolProperty($this, 'AreHostObjectsAllowed');
        $this->isZoomControlEnabledProperty = new BoolProperty($this, 'IsZoomControlEnabled');
        $this->isBuiltInErrorPageEnabledProperty = new BoolProperty($this, 'IsBuiltInErrorPageEnabled');
    }

    /**
     * @api
     */
    #[MapGetter(name: 'isScriptEnabled')]
    public function isScriptEnabled(): bool
    {
        return $this->isScriptEnabledProperty->get();
    }

    /**
     * @api
     */
    #[MapSetter(name: 'isScriptEnabled')]
    public function setScriptEnabled(bool $value): void
    {
        $this->isScriptEnabledProperty->set($value);
    }

    /**
     * @api
     */
    #[MapGetter(name: 'isWebMessageEnabled')]
    public function isWebMessageEnabled(): bool
    {
        return $this->isWebMessageEnabledProperty->get();
    }

    /**
     * @api
     */
    #[MapSetter(name: 'isWebMessageEnabled')]
    public function setWebMessageEnabled(bool $value): void
    {
        $this->isWebMessageEnabledProperty->set($value);
    }

    /**
     * @api
     */
    #[MapGetter(name: 'areDefaultScriptDialogsEnabled')]
    public function areDefaultScriptDialogsEnabled(): bool
    {
        return $this->areDefaultScriptDialogsEnabledProperty->get();
    }

    /**
     * @api
     */
    #[MapSetter(name: 'areDefaultScriptDialogsEnabled')]
    public function setDefaultScriptDialogsEnabled(bool $value): void
    {
        $this->areDefaultScriptDialogsEnabledProperty->set($value);
    }

    /**
     * @api
     */
    #[MapGetter(name: 'isStatusBarEnabled')]
    public function isStatusBarEnabled(): bool
    {
        return $this->isStatusBarEnabledProperty->get();
    }

    /**
     * @api
     */
    #[MapSetter(name: 'isStatusBarEnabled')]
    public function setStatusBarEnabled(bool $value): void
    {
        $this->isStatusBarEnabledProperty->set($value);
    }

    /**
     * @api
     */
    #[MapGetter(name: 'areDevToolsEnabled')]
    public function areDevToolsEnabled(): bool
    {
        return $this->areDevToolsEnabledProperty->get();
    }

    /**
     * @api
     */
    #[MapSetter(name: 'areDevToolsEnabled')]
    public function setDevToolsEnabled(bool $value): void
    {
        $this->areDevToolsEnabledProperty->set($value);
    }

    /**
     * @api
     */
    #[MapGetter(name: 'areDefaultContextMenusEnabled')]
    public function areDefaultContextMenusEnabled(): bool
    {
        return $this->areDefaultContextMenusEnabledProperty->get();
    }

    /**
     * @api
     */
    #[MapSetter(name: 'areDefaultContextMenusEnabled')]
    public function setDefaultContextMenusEnabled(bool $value): void
    {
        $this->areDefaultContextMenusEnabledProperty->set($value);
    }

    /**
     * @api
     */
    #[MapGetter(name: 'areHostObjectsAllowed')]
    public function areHostObjectsAllowed(): bool
    {
        return $this->areHostObjectsAllowedProperty->get();
    }

    /**
     * @api
     */
    #[MapSetter(name: 'areHostObjectsAllowed')]
    public function setHostObjectsAllowed(bool $value): void
    {
        $this->areHostObjectsAllowedProperty->set($value);
    }

    /**
     * @api
     */
    #[MapGetter(name: 'isZoomControlEnabled')]
    public function isZoomControlEnabled(): bool
    {
        return $this->isZoomControlEnabledProperty->get();
    }

    /**
     * @api
     */
    #[MapSetter(name: 'isZoomControlEnabled')]
    public function setZoomControlEnabled(bool $value): void
    {
        $this->isZoomControlEnabledProperty->set($value);
    }

    /**
     * @api
     */
    #[MapGetter(name: 'isBuiltInErrorPageEnabled')]
    public function isBuiltInErrorPageEnabled(): bool
    {
        return $this->isBuiltInErrorPageEnabledProperty->get();
    }

    /**
     * @api
     */
    #[MapSetter(name: 'isBuiltInErrorPageEnabled')]
    public function setBuiltInErrorPageEnabled(bool $value): void
    {
        $this->isBuiltInErrorPageEnabledProperty->set($value);
    }
}
