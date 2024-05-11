<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Managed;

use FFI\CData;
use FFI\Proxy\ApiInterface;
use Serafim\WinUI\Driver\Win32\Managed\Reader\StructNameReader;

abstract class LocalCreated extends LocalManaged
{
    private static ?StructNameReader $nameReader = null;

    public function __construct(CData $ptr)
    {
        parent::__construct($ptr);
    }

    private static function getStructNameReader(): StructNameReader
    {
        return self::$nameReader ??= new StructNameReader();
    }

    public static function allocate(ApiInterface|\FFI $api): CData
    {
        $structures = self::getStructNameReader();

        $name = $structures->read(static::class);

        $webview = $api->new($name, false);
        $webview->lpVtbl = $api->new($name . 'Vtbl', false);

        return \FFI::addr($webview);
    }

    public function __destruct()
    {
        parent::__destruct();

        \FFI::free(\FFI::addr($this->ptr));
    }
}
