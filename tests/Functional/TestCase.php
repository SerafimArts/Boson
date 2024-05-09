<?php

declare(strict_types=1);

namespace Serafim\WinUI\Tests\Functional;

use PHPUnit\Framework\Attributes\Group;
use Serafim\WinUI\Tests\TestCase as BaseTestCase;

#[Group('functional'), Group('serafim/winui')]
abstract class TestCase extends BaseTestCase {}
