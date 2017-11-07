<?php

namespace App\Controllers;

use App\Models\PageModel;

class PageController extends AppController
{
    public $name = 'Page';
    public $pageTitle = 'ChronosPHP';

    public function init()
    {
        //$n = (new PageModel())->r();
    }

    public function index()
    {
        $this->set('varX', 'dataX');
    }

    public function getX()
    {
        return 1;
    }
}
