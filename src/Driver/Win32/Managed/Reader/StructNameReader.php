<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Managed\Reader;

use Serafim\WinUI\Driver\Win32\Managed\ManagedStruct;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\WinUI\Driver\Win32\Managed
 */
final class StructNameReader
{
    /**
     * @var array<class-string, non-empty-string>
     */
    private array $names = [];

    public function read(object $ctx): string
    {
        return $this->names[$ctx::class] ??= $this->readFromObject($ctx);
    }

    /**
     * @return non-empty-string
     */
    private function readFromObject(object $ctx): string
    {
        return $this->readFromReflection(new \ReflectionObject($ctx));
    }

    /**
     * @return non-empty-string
     */
    private function readFromReflection(\ReflectionObject $ctx): string
    {
        foreach ($ctx->getAttributes(ManagedStruct::class) as $attribute) {
            /** @var ManagedStruct $instance */
            $instance = $attribute->newInstance();

            if ($instance->name !== null) {
                return $instance->name;
            }
        }

        /** @var non-empty-string */
        return $ctx->getShortName();
    }
}
