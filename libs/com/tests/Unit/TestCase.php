<?php

declare(strict_types=1);

namespace Local\Com\Tests\Unit;

use PHPUnit\Framework\Attributes\Group;
use Local\Com\Tests\TestCase as BaseTestCase;

#[Group('unit'), Group('local/com')]
abstract class TestCase extends BaseTestCase {}
