<?php

declare(strict_types=1);

namespace Serafim\Boson\Tests\Functional;

use PHPUnit\Framework\Attributes\Group;
use Serafim\Boson\Tests\TestCase as BaseTestCase;

#[Group('functional'), Group('serafim/boson')]
abstract class TestCase extends BaseTestCase {}
