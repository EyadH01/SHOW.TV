<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * @method void markTestSkipped(string $message = '')
 * @method void assertNotNull($actual, string $message = '')
 * @method void assertNull($actual, string $message = '')
 * @method void assertTrue($condition, string $message = '')
 * @method void assertFalse($condition, string $message = '')
 * @method void assertEquals($expected, $actual, string $message = '')
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
