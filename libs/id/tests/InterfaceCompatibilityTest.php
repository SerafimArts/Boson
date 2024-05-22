<?php

declare(strict_types=1);

namespace Local\Id\Tests;

use Local\Id\IdentifiableInterface;
use Local\Id\IdFactoryInterface;
use Local\Id\IdGenerator\GeneratorInterface;
use Local\Id\IdInterface;
use PHPUnit\Framework\Attributes\Group;

/**
 * Note: Changing the behavior of these tests is allowed ONLY when updating
 *       a MAJOR version of the package.
 */
#[Group('local/id')]
class InterfaceCompatibilityTest extends TestCase
{
    public function testIdentifiableCompatibility(): void
    {
        self::expectNotToPerformAssertions();

        new class () implements IdentifiableInterface {
            #[\Override]
            public function getId(): IdInterface {}
        };
    }

    public function testIdFactoryCompatibility(): void
    {
        self::expectNotToPerformAssertions();

        new class () implements IdFactoryInterface {
            #[\Override]
            public function create(mixed $id = null): IdInterface {}
        };
    }

    public function testIdCompatibility(): void
    {
        self::expectNotToPerformAssertions();

        new class () implements IdInterface {
            #[\Override]
            public function equals(IdInterface $id): bool {}
            #[\Override]
            public function toPrimitive(): mixed {}
            #[\Override]
            public function __toString(): string {}
        };
    }

    public function testIdGeneratorCompatibility(): void
    {
        self::expectNotToPerformAssertions();

        new class () implements GeneratorInterface {
            #[\Override]
            public function nextId(): IdInterface {}
        };
    }
}
