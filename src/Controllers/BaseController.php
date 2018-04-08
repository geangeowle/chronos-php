<?php

namespace Chronos\Controllers;

use Chronos\Controllers\Controller;

abstract class BaseController extends Controller
{
    public $pageTitle = 'chronosPHP 1.x';

    public function __construct()
    {
        parent::__construct();
        $this->initialize();
    }

    abstract public function initialize();

    abstract public function index();
}
