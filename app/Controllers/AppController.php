<?php

namespace App\Controllers;

use Chronos\Controllers\Controller;

abstract class AppController extends Controller
{
    abstract public function index();
}
