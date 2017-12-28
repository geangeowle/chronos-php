<?php

namespace Chronos\Test\Unit\Utils;

use Chronos\Utils\Inflector;

class InflectorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * testUnderscore method.
     */
    public function testUnderscore()
    {
        // Test values
        $this->assertSame('test_string', Inflector::underscore('TestString'));
        $this->assertSame('test_string', Inflector::underscore('testString'));
        $this->assertSame('test_string_extra', Inflector::underscore('TestStringExtra'));
        $this->assertSame('test_string_extra', Inflector::underscore('testStringExtra'));
        $this->assertSame('test_this_string', Inflector::underscore('test-this-string'));
        $this->assertSame('test_this_string', Inflector::underscore('test-thisString'));

        // Test stupid values
        $this->assertSame('', Inflector::underscore(''));
        $this->assertSame('0', Inflector::underscore(0));
        $this->assertSame('', Inflector::underscore(false));
        $this->assertSame('p@ss_w0rd', Inflector::underscore('P@ssW0rd'));
    }

    /**
     * testHumanize method.
     */
    public function testHumanize()
    {
        // Test values
        $this->assertSame('Test String', Inflector::humanize('test_string'));
        $this->assertSame('Test String Extra', Inflector::humanize('test_string_extra'));
        $this->assertSame('Test This String', Inflector::humanize('test-this-string'));
        $this->assertSame('Test This String', Inflector::humanize('Test This String'));
        $this->assertSame('Test This String', Inflector::humanize('Test-This-String'));

        // Test stupid values
        $this->assertSame('', Inflector::humanize(''));
        $this->assertSame('0', Inflector::humanize(0));
        $this->assertSame('', Inflector::humanize(false));
        $this->assertSame('P@ss W0rd', Inflector::humanize('p@ss_w0rd'));
    }

    /**
     * testCamelize method.
     */
    public function testCamelize()
    {
        // Test values
        $this->assertSame('TestString', Inflector::camelize('test_string'));
        $this->assertSame('TestStringExtra', Inflector::camelize('test_string_extra'));
        $this->assertSame('TestThisString', Inflector::camelize('test-this-string'));
        $this->assertSame('TestThisString', Inflector::camelize('Test This String'));
        $this->assertSame('TestThisString', Inflector::camelize('TestThisString'));

        // Test stupid values
        $this->assertSame('', Inflector::camelize(''));
        $this->assertSame('0', Inflector::camelize(0));
        $this->assertSame('', Inflector::camelize(false));
        $this->assertSame('P@ssW0rd', Inflector::camelize('p@ss_w0rd'));
    }

    /**
     * testDelimit method.
     */
    public function testDelimit()
    {
        // Test values - Delimiter '_'
        $this->assertSame('test string', Inflector::delimit('Test String'));
        $this->assertSame('test_string', Inflector::delimit('testString'));
        $this->assertSame('test_string_extra', Inflector::delimit('TestStringExtra'));
        $this->assertSame('test_string_extra', Inflector::delimit('testStringExtra'));
        $this->assertSame('test-this-string', Inflector::delimit('test-this-string'));
        $this->assertSame('test-this_string', Inflector::delimit('test-thisString'));

        // Test values - Delimiter '-'
        $this->assertSame('test string', Inflector::delimit('Test String', '-'));
        $this->assertSame('test-string', Inflector::delimit('testString', '-'));
        $this->assertSame('test-string-extra', Inflector::delimit('TestStringExtra', '-'));
        $this->assertSame('test-string-extra', Inflector::delimit('testStringExtra', '-'));
        $this->assertSame('test-this-string', Inflector::delimit('test-this-string', '-'));
        $this->assertSame('test-this-string', Inflector::delimit('test-thisString', '-'));

        // Test stupid values
        $this->assertSame('', Inflector::delimit(''));
        $this->assertSame('0', Inflector::delimit(0));
        $this->assertSame('', Inflector::delimit(false));
        $this->assertSame('p@ss_w0rd', Inflector::delimit('P@ssW0rd'));
    }

    public function testCheckAllMethodsHasTest()
    {
        $methodsOfInflectorClass = get_class_methods(Inflector::class);
        foreach ($methodsOfInflectorClass as $k => $methodOfInflectorClass) {
            $method = 'test'.ucwords($methodOfInflectorClass);
            $message = 'Is missing test of '.$methodOfInflectorClass;
            $isCallable = is_callable([$this, $method]);
            $this->assertTrue($isCallable, $message);
        }
    }
}
