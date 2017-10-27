<?php

namespace Chronos\Controllers;

use App\Controllers\AppController;

final class ErrorController extends AppController
{
    public $name = 'Error';
    public $layout = 'default_error';
    public $pageTitle = 'ChronosPHP Error';

    public function index()
    {
    }

    public function missingClass($className = '')
    {
    }

    public function missingMethod($methodName = '')
    {
    }
}
