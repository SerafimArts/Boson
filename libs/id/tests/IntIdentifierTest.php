<?php

declare(strict_types=1);

namespace Local\Id\Tests;

use Local\Id\IntIdentifier;
use Local\Id\StringIdentifier;
use PHPUnit\Framework\Attributes\Group;

#[Group('local/id')]
final class IntIdentifierTest extends TestCase
{
    public function testSameInstance(): void
    {
        $id = new IntIdentifier(0xDEAD_BEEF);

        self::assertTrue($id->equals($id));
    }

    public function testEqualIntInstance(): void
    {
        $id = new IntIdentifier(0xDEAD_BEEF);

        self::assertTrue($id->equals(new IntIdentifier(
            0xDEAD_BEEF,
        )));
    }

    public function testNotEqualAnotherIntInstance(): void
    {
        $id = new IntIdentifier(0xDEAD_BEEF);

        self::assertFalse($id->equals(new IntIdentifier(
            0xDEAD_BEEF + 1,
        )));
    }

    public function testEqualStringInstance(): void
    {
        $id = new IntIdentifier(0xDEAD_BEEF);

        self::assertTrue($id->equals(new StringIdentifier(
            (string) 0xDEAD_BEEF,
        )));
    }

    public function testNotEqualAnotherStringInstance(): void
    {
        $id = new IntIdentifier(0xDEAD_BEEF);

        self::assertFalse($id->equals(new StringIdentifier(
            (string) (0xDEAD_BEEF + 1),
        )));
    }

    public function testPositivePrimitiveValue(): void
    {
        $id = new IntIdentifier(0xDEAD_BEEF);

        self::assertSame(0xDEAD_BEEF, $id->toPrimitive());
    }

    public function testNegativePrimitiveValue(): void
    {
        $id = new IntIdentifier(-0xDEAD_BEEF);

        self::assertSame(-0xDEAD_BEEF, $id->toPrimitive());
    }

    public function testStringRepresentation(): void
    {
        $id = new IntIdentifier(0xDEAD_BEEF);

        self::assertSame((string) 0xDEAD_BEEF, (string) $id);
    }
}
