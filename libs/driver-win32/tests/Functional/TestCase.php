<?php

declare(strict_types=1);

namespace Local\Driver\Win32\Tests\Functional;

use PHPUnit\Framework\Attributes\Group;
use Local\Driver\Win32\Tests\TestCase as BaseTestCase;

#[Group('functional'), Group('local/driver-win32')]
abstract class TestCase extends BaseTestCase {}
