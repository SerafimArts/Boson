<?php

declare(strict_types=1);

namespace Serafim\Boson\WebView\Requests\IdGenerator;

use Serafim\Boson\Exception\IdOverflowException;

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
