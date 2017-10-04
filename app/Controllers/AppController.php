<?php

namespace App\Controllers;

use Chronos\Controllers\Controller;

abstract class AppController extends Controller
{
    public function __construct($newConfig = [])
    {
        parent::__construct($newConfig);
        $this->init();
    }

    abstract public function init();

    abstract public function index();
}
