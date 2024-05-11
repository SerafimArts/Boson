<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Managed;

use FFI\CData;
use FFI\Proxy\ApiInterface;
use Serafim\WinUI\Driver\Win32\Managed\Reader\StructFunctionReader;
use Serafim\WinUI\Driver\Win32\Managed\Reader\StructNameReader;

abstract class ExternalManaged
{
    private ?CData $virtualTable = null;

    private ?CData $struct = null;

    private static ?StructNameReader $nameReader = null;

    private static ?StructFunctionReader $functionReader = null;

    private static function getStructNameReader(): StructNameReader
    {
        return self::$nameReader ??= new StructNameReader();
    }

    private static function getStructFunctionReader(): StructFunctionReader
    {
        return self::$functionReader ??= new StructFunctionReader();
    }

    public function get(\FFI|ApiInterface $ctx): CData
    {
        if ($this->struct !== null) {
            return $this->struct;
        }

        $structures = self::getStructNameReader();

        $name = $structures->read(static::class);

        if ($this->virtualTable === null) {
            $this->virtualTable = $ctx->new(\sprintf('%sVtbl', $name));

            $functions = self::getStructFunctionReader();

            foreach ($functions->read($this) as $function => $callback) {
                // @phpstan-ignore-next-line
                $this->virtualTable->$function = $callback;
            }
        }

        $this->struct = $ctx->new($name);
        // @phpstan-ignore-next-line
        $this->struct->lpVtbl = \FFI::addr($this->virtualTable);

        // @phpstan-ignore-next-line
        return $this->struct;
    }
}
