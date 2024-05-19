<?php

declare(strict_types=1);

namespace Local\Property\Tests\Unit;

use PHPUnit\Framework\Attributes\Group;
use Local\Property\Tests\TestCase as BaseTestCase;

#[Group('unit'), Group('local/property')]
abstract class TestCase extends BaseTestCase {}
