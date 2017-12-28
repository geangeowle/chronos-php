<?php

namespace Chronos\Test\Unit\Utils;

use Chronos\TestSuite\ChronosTestCase;
use Chronos\Utils\Configure;

class ConfigureTest extends ChronosTestCase //\PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $this->setClassOfTest(Configure::class);
    }

    public function testRead()
    {
        $expected = 'ok';
        Configure::write('level1.level2.level3_1', $expected);
        Configure::write('level1.level2.level3_2', 'something_else');
        $result = Configure::read('level1.level2.level3_1');
        $this->assertSame($expected, $result);

        $result = Configure::read('level1.level2.level3_2');
        $this->assertSame('something_else', $result);

        $result = Configure::read();
        $this->assertSame(null, $result);

        $result = Configure::read('something_key_not_exists');
        $this->assertSame(null, $result, 'Missing key should return null.');
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf(Configure::class, Configure::getInstance());
    }

    public function testWrite()
    {
        $writeResult = Configure::write('SomeConfigName.someKey', 'value');
        $this->assertTrue($writeResult);
        $result = Configure::read('SomeConfigName.someKey');
        $this->assertSame('value', $result);

        $writeResult = Configure::write('SomeConfigName.someKey', null);
        $this->assertTrue($writeResult);
        $result = Configure::read('SomeConfigName.someKey');
        $this->assertSame(null, $result);

        $expected = ['One' => ['Two' => ['Three' => 'cool']]];
        $writeResult = Configure::write('Key', $expected);
        $this->assertTrue($writeResult);
        $result = Configure::read('Key');
        $this->assertSame($expected, $result);
        $result = Configure::read('Key.One');
        $this->assertSame($expected['One'], $result);
        $result = Configure::read('Key.One.Two');
        $this->assertSame($expected['One']['Two'], $result);
        Configure::write('one.two.three', '3');
        $result = Configure::read('one.two.three');
        $this->assertSame('3', $result);
    }
}
