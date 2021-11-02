<?php

namespace Moneybatch\Minimalist\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function markTestSucceeded()
    {
        $this->assertTrue(true);
    }
}
