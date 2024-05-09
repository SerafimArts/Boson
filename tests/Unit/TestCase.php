<?php

declare(strict_types=1);

namespace Serafim\WinUI\Tests\Unit;

use PHPUnit\Framework\Attributes\Group;
use Serafim\WinUI\Tests\TestCase as BaseTestCase;

#[Group('unit'), Group('serafim/winui')]
abstract class TestCase extends BaseTestCase {}
