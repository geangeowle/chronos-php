<?php

namespace Chronos\TestSuite;

use PHPUnit\Framework\TestCase as BaseTestCase;

class ChronosTestCase extends BaseTestCase
{
    protected $classOfTest;

    public function testCheckAllMethodsHasTest()
    {
        $methodsOfClassTest = get_class_methods($this->classOfTest);
        foreach ($methodsOfClassTest as $k => $methodOfClassTest) {
            $method = 'test'.ucwords($methodOfClassTest);
            $message = 'Is missing test of '.$methodOfClassTest;
            $isCallable = is_callable([$this, $method]);
            $this->assertTrue($isCallable, $message.'['.$method.']');
        }
    }

    protected function setClassOfTest($classOfTest)
    {
        $this->classOfTest = $classOfTest;
    }
}
