<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver\Win32\Managed\Reader;

use Serafim\WinUI\Driver\Win32\Managed\ManagedFunction;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\WinUI\Driver\Win32\Managed
 */
final class StructFunctionReader
{
    /**
     * @var array<class-string, array<non-empty-string, callable>>
     */
    private array $names = [];

    public function read(object $ctx): array
    {
        return $this->names[$ctx::class] ??= $this->readFromObject($ctx);
    }

    /**
     * @return array<non-empty-string, callable>
     */
    private function readFromObject(object $ctx): array
    {
        $reflection = new \ReflectionObject($ctx);
        $result = [];

        foreach ($reflection->getMethods() as $method) {
            foreach ($method->getAttributes(ManagedFunction::class) as $attribute) {
                /** @var ManagedFunction $instance */
                $instance = $attribute->newInstance();

                $result[$instance->name ?? $method->name] = $method->getClosure($ctx);
            }
        }

        /** @var array<non-empty-string, callable> */
        return $result;
    }
}
