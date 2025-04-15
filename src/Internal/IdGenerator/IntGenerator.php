<?php

declare(strict_types=1);

namespace Serafim\Boson\Internal\IdGenerator;

use Serafim\Boson\Internal\IdGenerator\Exception\IdOverflowException;

/**
 * @template TInteger of int<min, max>
 * @template-implements GeneratorInterface<TInteger>
 */
abstract class IntGenerator implements GeneratorInterface
{
    /**
     * @var TInteger
     */
    protected int $current;

    /**
     * Gets initial value of generator
     *
     * @var TInteger
     */
    abstract public int $initial { get; }

    /**
     * Gets maximum supported generator value
     *
     * @var TInteger
     */
    abstract public int $maximum { get; }

    public function __construct(
        private readonly OverflowBehaviour $onOverflow = OverflowBehaviour::Reset,
    ) {
        $this->current = $this->initial;
    }

    /**
     * @return GeneratorInterface<array-key>
     */
    public static function createFromEnvironment(): GeneratorInterface
    {
        if (\PHP_INT_SIZE >= 8) {
            return new Int64Generator();
        }

        return new Int32Generator();
    }

    /**
     * @throws IdOverflowException
     */
    protected function reset(): void
    {
        if ($this->onOverflow === OverflowBehaviour::Exception) {
            throw IdOverflowException::becauseClassOverflows(static::class, (string) $this->current);
        }

        $this->current = $this->initial;
    }

    /**
     * @return TInteger
     * @throws IdOverflowException
     */
    public function nextId(): int
    {
        $value = ++$this->current;

        if ($value >= $this->maximum) {
            $this->reset();
        }

        /** @var TInteger */
        return $value;
    }
}
