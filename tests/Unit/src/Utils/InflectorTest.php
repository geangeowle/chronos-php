<?php

namespace Chronos\Test\Unit\Utils;

use Chronos\Utils\Inflector;

class InflectorTest extends \PHPUnit\Framework\TestCase
{

    public function testInflectorUnderscoreReturnsUndercoreString()
    {
      $this->assertSame(Inflector::underscore('TestInflectorUnderscore'), 'test_inflector_underscore');
      $this->assertSame(Inflector::humanize('test_inflector_underscore'), 'Test Inflector Underscore');
    }
}
