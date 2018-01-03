<?php

namespace Chronos\Test\Unit;

use Chronos\TestSuite\ChronosTestCase;

require_once dirname(dirname(dirname(__DIR__))).'/src/functions.php';

class functionsTest extends ChronosTestCase
{
    /**
     * test pr().
     */
    public function testPr()
    {
        ob_start();
        $this->assertTrue(pr(true));
        $result = ob_get_clean();
        $expected = "\n1\n\n";
        $this->assertSame($expected, $result);

        ob_start();
        $this->assertFalse(pr(false));
        $result = ob_get_clean();
        $expected = "\n\n\n";
        $this->assertSame($expected, $result);

        ob_start();
        $this->assertNull(pr(null));
        $result = ob_get_clean();
        $expected = "\n\n\n";
        $this->assertSame($expected, $result);

        ob_start();
        $this->assertSame(123, pr(123));
        $result = ob_get_clean();
        $expected = "\n123\n\n";
        $this->assertSame($expected, $result);

        ob_start();
        pr('123');
        $result = ob_get_clean();
        $expected = "\n123\n\n";
        $this->assertSame($expected, $result);

        ob_start();
        pr('this is a test');
        $result = ob_get_clean();
        $expected = "\nthis is a test\n\n";
        $this->assertSame($expected, $result);

        ob_start();
        pr(['this' => 'is', 'a' => 'test', 123 => 456]);
        $result = ob_get_clean();
        $expected = "\nArray\n(\n    [this] => is\n    [a] => test\n    [123] => 456\n)\n\n";
        $this->assertSame($expected, $result);
    }
}
