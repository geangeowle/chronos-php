<?php

namespace App\Controllers;

use App\Controllers\AppController;

final class PageController extends AppController
{
    public $name = 'Page';
    public $pageTitle = 'ChronosPHP';
    public $uses = ['Error'];

    public function index(){

    }
}
