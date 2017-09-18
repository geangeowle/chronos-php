<?php

namespace Chronos\Controllers;

final class ErrorController extends AppController
{
    public $name = 'Error';
    public $layout = 'default_error';
    public $pageTitle = 'ChronosPHP Error';

    public function missingClass($className = '')
    {
        // echo '--->';
        // print_r($className);
        //$this->set("dsClassMissing", $className);
    }

    public function missingMethod($methodName = '')
    {
    }
}
