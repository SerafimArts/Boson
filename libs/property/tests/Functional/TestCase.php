<?php

declare(strict_types=1);

namespace Local\Property\Tests\Functional;

use PHPUnit\Framework\Attributes\Group;
use Local\Property\Tests\TestCase as BaseTestCase;

#[Group('functional'), Group('local/property')]
abstract class TestCase extends BaseTestCase {}
