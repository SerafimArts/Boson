<?php

declare(strict_types=1);

namespace Local\Id\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase as BaseTestCase;

#[Group('local/id')]
abstract class TestCase extends BaseTestCase
{
    protected function assertionsEnabled(): bool
    {
        try {
            assert(false);
            return false;
        } catch (\Throwable $e) {
            return true;
        }
    }
}
