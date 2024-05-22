<?php

declare(strict_types=1);

namespace Local\Id\IdGenerator;

use Local\Id\IdFactory;
use Local\Id\IdFactoryInterface;
use Local\Id\IdInterface;

/**
 * @template-implements GeneratorInterface<int>
 */
final readonly class IntPlatformGenerator implements GeneratorInterface
{
    /**
     * @var IntGenerator<int>
     */
    private IntGenerator $generator;

    public function __construct(
        IdFactoryInterface $ids = new IdFactory(),
        OverflowBehaviour $onOverflow = OverflowBehaviour::RESET,
    ) {
        $this->generator = $this->createGenerator($ids, $onOverflow);
    }

    /**
     * @return IntGenerator<int>
     */
    private function createGenerator(IdFactoryInterface $ids, OverflowBehaviour $onOverflow): IntGenerator
    {
        if (\PHP_INT_SIZE === 4) {
            // @phpstan-ignore-next-line
            return new Int32Generator($ids, $onOverflow);
        }

        // @phpstan-ignore-next-line
        return new Int64Generator($ids, $onOverflow);
    }

    public function nextId(): IdInterface
    {
        return $this->generator->nextId();
    }
}
