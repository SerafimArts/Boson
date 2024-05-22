<?php

declare(strict_types=1);

namespace Local\Id\Tests;

use Local\Id\IntIdentifier;
use Local\Id\StringIdentifier;
use PHPUnit\Framework\Attributes\Group;

#[Group('local/id')]
final class StringIdentifierTest extends TestCase
{
    public function testEmptyStringNotAllowed(): void
    {
        if (!$this->assertionsEnabled()) {
            self::markTestSkipped('PHP assertions not enabled');
        }

        self::expectExceptionMessage('String identifier cannot be empty');

        new StringIdentifier('');
    }

    public function testSameInstance(): void
    {
        $id = new StringIdentifier('example');

        self::assertTrue($id->equals($id));
    }

    public function testEqualStringInstance(): void
    {
        $id = new StringIdentifier('example');

        self::assertTrue($id->equals(new StringIdentifier(
            'example',
        )));
    }

    public function testNotEqualAnotherStringInstance(): void
    {
        $id = new StringIdentifier('example');

        self::assertFalse($id->equals(new StringIdentifier(
            'example-another',
        )));
    }

    public function testEqualIntInstance(): void
    {
        $id = new StringIdentifier((string) 0xDEAD_BEEF);

        self::assertTrue($id->equals(new IntIdentifier(
            0xDEAD_BEEF,
        )));
    }

    public function testNotEqualAnotherIntInstance(): void
    {
        $id = new StringIdentifier((string) 0xDEAD_BEEF);

        self::assertFalse($id->equals(new IntIdentifier(
            0xDEAD_BEEF + 1,
        )));
    }

    public function testPrimitiveValue(): void
    {
        $id = new StringIdentifier('example');

        self::assertSame('example', $id->toPrimitive());
    }

    public function testStringRepresentation(): void
    {
        $id = new StringIdentifier('example');

        self::assertSame('example', (string) $id);
    }
}
