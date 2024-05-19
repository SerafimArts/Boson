<?php

declare(strict_types=1);

namespace Local\WebView2\Tests\Unit;

use PHPUnit\Framework\Attributes\Group;
use Local\WebView2\Tests\TestCase as BaseTestCase;

#[Group('unit'), Group('local/webview2')]
abstract class TestCase extends BaseTestCase {}
