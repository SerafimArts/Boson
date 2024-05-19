<?php

declare(strict_types=1);

namespace Local\Com\Tests\Functional;

use PHPUnit\Framework\Attributes\Group;
use Local\Com\Tests\TestCase as BaseTestCase;

#[Group('functional'), Group('local/com')]
abstract class TestCase extends BaseTestCase {}
