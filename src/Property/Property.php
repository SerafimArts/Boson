<?php

declare(strict_types=1);

namespace Serafim\WinUI\Property;

/**
 * @template TRead of mixed
 * @template TWrite of mixed
 */
final readonly class Property
{
    /**
     * The property getter.
     *
     * @var (\Closure():TRead)|null
     */
    public ?\Closure $getter;

    /**
     * The property setter.
     *
     * @var (\Closure(TWrite):mixed)|null
     */
    public ?\Closure $setter;

    /**
     * Contains {@see true} if the {@see MapProperty} object must be
     * initialized once for one property or {@see false} instead.
     */
    public bool $memoized;

    /**
     * @param (callable():TRead)|null $get
     * @param (callable(TWrite):mixed)|null $set
     */
    final public function __construct(
        ?callable $get = null,
        ?callable $set = null,
        bool $memoized = true,
    ) {
        if ($get === null && $set === null) {
            throw new \InvalidArgumentException('Property must have either read or write');
        }

        $this->getter = $get === null ? null : $get(...);
        $this->setter = $set === null ? null : $set(...);
        $this->memoized = $memoized;
    }

    /**
     * @template TReadArg of mixed
     * @template TWriteArg of mixed
     *
     * @param (callable():TReadArg)|null $get
     * @param (callable(TWriteArg):mixed)|null $set
     *
     * @return self<($get is null ? never : TReadArg), ($set is null ? never : TWriteArg)>
     * @api
     */
    public static function new(?callable $get = null, ?callable $set = null): self
    {
        return new self($get, $set);
    }

    /**
     * @template TReadArg of mixed
     *
     * @param callable():TReadArg $get
     *
     * @return self<TReadArg, never>
     * @api
     */
    public static function getter(callable $get): self
    {
        /** @var self<TReadArg, never> */
        return new self(get: $get);
    }

    /**
     * @template TWriteArg of mixed
     *
     * @param callable(TWriteArg):mixed $set
     *
     * @return self<never, TWriteArg>
     * @api
     */
    public static function setter(callable $set): self
    {
        /** @var self<never, TWriteArg> */
        return new self(set: $set);
    }

    /**
     * @template TReadArg of mixed
     *
     * @param callable():TReadArg $get
     *
     * @return self<TReadArg, TWrite>
     * @api
     */
    public function withGetter(callable $get): self
    {
        return new self(
            get: $get,
            set: $this->setter,
            memoized: $this->memoized,
        );
    }

    /**
     * @template TWriteArg of mixed
     *
     * @param callable(TWriteArg):mixed $set
     *
     * @return self<TRead, TWriteArg>
     * @api
     */
    public function withSetter(callable $set): self
    {
        return new self(
            get: $this->getter,
            set: $set,
            memoized: $this->memoized,
        );
    }

    /**
     * @return self<TRead, TWrite>
     * @api
     */
    public function withMemoization(): self
    {
        return new self(
            get: $this->getter,
            set: $this->setter,
            memoized: true,
        );
    }

    /**
     * @return self<TRead, TWrite>
     * @api
     */
    public function withoutMemoization(): self
    {
        return new self(
            get: $this->getter,
            set: $this->setter,
            memoized: false,
        );
    }
}
