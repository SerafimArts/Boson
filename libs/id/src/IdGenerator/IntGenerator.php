<?php

declare(strict_types=1);

namespace Local\Id\IdGenerator;

use Local\Id\Exception\IdOverflowException;
use Local\Id\IdFactory;
use Local\Id\IdFactoryInterface;
use Local\Id\IdInterface;

/**
 * @template TValue of int
 *
 * @template-implements GeneratorInterface<TValue>
 */
abstract class IntGenerator implements GeneratorInterface
{
    /**
     * @var TValue
     */
    protected int $current;

    /**
     * @var TValue
     */
    private readonly int $initial;

    /**
     * @var TValue
     */
    private readonly int $maximum;

    public function __construct(
        private readonly IdFactoryInterface $ids = new IdFactory(),
        private readonly OverflowBehaviour $onOverflow = OverflowBehaviour::RESET,
    ) {
        $this->current = $this->initial = $this->getInitialValue();
        $this->maximum = $this->getMaximalValue();
    }

    /**
     * @return TValue
     */
    abstract public function getInitialValue(): int;

    /**
     * @return TValue
     */
    abstract public function getMaximalValue(): int;

    /**
     * @throws IdOverflowException
     */
    protected function reset(): void
    {
        if ($this->onOverflow === OverflowBehaviour::EXCEPTION) {
            throw IdOverflowException::fromMaxValueOfClass(static::class, (string) $this->current);
        }

        $this->current = $this->initial;
    }

    /**
     * @return IdInterface<TValue>
     * @throws IdOverflowException
     * @throws \Throwable
     */
    public function nextId(): IdInterface
    {
        /**
         * @var TValue $value
         */
        $value = ++$this->current;

        if ($value >= $this->maximum) {
            $this->reset();
        }

        /** @var IdInterface<TValue> */
        return $this->ids->create($value);
    }
}
