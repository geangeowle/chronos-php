<?php

use Chronos\Utils\Inflector;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class InflectorTest extends TestCase
{
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
