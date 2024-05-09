<?php

declare(strict_types=1);

namespace Serafim\WinUI\Driver;

use FFI\Env\Runtime;
use FFI\Proxy\Proxy as BaseProxy;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal Serafim\WinUI
 *
 * @mixin \FFI
 */
abstract class Library extends BaseProxy
{
    /**
     * @var array<class-string<Library>, Library>
     */
    private static array $instances = [];

    /**
     * @param non-empty-string|null $library
     */
    public function __construct(?string $library = null)
    {
        Runtime::assertAvailable();

        parent::__construct(\FFI::cdef(static::getHeader(), $library));
    }

    public static function getInstance(): static
    {
        // @phpstan-ignore-next-line
        return self::$instances[static::class] ??= new static();
    }

    abstract public static function getHeader(): string;
}
