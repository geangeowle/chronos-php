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

    /**
     * [testUnderscoreReturnsUnderscoreString description].
     *
     * @dataProvider providerTestUnderscoreReturnsUnderscoreString
     *
     * @param mixed $originalString
     * @param mixed $expectedResult
     *
     * @return [type] [description]
     */
    public function testUnderscoreReturnsUnderscoreString($originalString, $expectedResult)
    {
        $result = Inflector::underscore($originalString);
        $this->assertSame($expectedResult, $result);
    }

    public function providerTestUnderscoreReturnsUnderscoreString()
    {
        return [
            ['TestUnderscoreReturnsUnderscoreString', 'test_underscore_returns_underscore_string'],
            ['TestUnderscore2ReturnsUnderscoreString2', 'test_underscore2_returns_underscore_string2'],
            ['123', '123'],
        ];
    }
}
