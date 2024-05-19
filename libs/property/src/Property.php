<?php

declare(strict_types=1);

namespace Local\Property;

/**
 * @template TRead of mixed
 * @template TWrite of mixed
 *
 * @template-implements PropertyInterface<TRead, TWrite>
 */
final readonly class Property implements PropertyInterface
{
    /**
     * @var \Closure():TRead
     */
    private \Closure $get;

    /**
     * @var \Closure(TWrite):mixed
     */
    private \Closure $set;

    /**
     * @param callable():TRead $get
     * @param callable(TWrite):mixed $set
     */
    public function __construct(callable $get, callable $set)
    {
        $this->get = $get(...);
        $this->set = $set(...);
    }

    /**
     * @api
     * @template TReadArg of mixed
     * @template TWriteArg of mixed
     *
     * @param (callable():TReadArg) $get
     * @param (callable(TWriteArg):mixed) $set
     *
     * @return PropertyInterface<TReadArg, TWriteArg>
     */
    public static function new(callable $get, callable $set): PropertyInterface
    {
        return new self($get, $set);
    }

    /**
     * @api
     * @template TReadArg of mixed
     *
     * @param callable():TReadArg $get
     *
     * @return ReadablePropertyInterface<TReadArg>
     */
    public static function getter(callable $get): ReadablePropertyInterface
    {
        return new ReadableProperty($get);
    }

    /**
     * @api
     * @template TWriteArg of mixed
     *
     * @param callable(TWriteArg):mixed $set
     *
     * @return WritablePropertyInterface<TWriteArg>
     */
    public static function setter(callable $set): WritablePropertyInterface
    {
        return new WritableProperty($set);
    }

    /**
     * @return TRead
     */
    public function get(): mixed
    {
        return ($this->get)();
    }

    /**
     * @param TWrite $value
     */
    public function set(mixed $value): void
    {
        ($this->set)($value);
    }
}
