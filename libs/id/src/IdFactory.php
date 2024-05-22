<?php

declare(strict_types=1);

namespace Local\Id;

use Local\Id\Exception\IdNotSupportedException;

final readonly class IdFactory implements IdFactoryInterface
{
    /**
     * @var list<non-empty-string>
     */
    private const array SUPPORTED_TYPES = [
        'int',
        'non-empty-string'
    ];

    public function create(mixed $id = null): IdInterface
    {
        if ($id instanceof \Stringable) {
            $id = (string) $id;
        }

        // @phpstan-ignore-next-line
        return match (true) {
            $id === '' => throw IdNotSupportedException::fromInvalidPlatform(
                expected: \implode('|', self::SUPPORTED_TYPES),
                actual: 'empty-string',
            ),
            // @phpstan-ignore-next-line
            \is_string($id) => new StringIdentifier($id),
            \is_int($id) => new IntIdentifier($id),
            default => throw IdNotSupportedException::fromInvalidPlatform(
                expected: \implode('|', self::SUPPORTED_TYPES),
                actual: \get_debug_type($id),
            ),
        };
    }
}
