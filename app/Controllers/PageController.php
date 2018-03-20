<?php

namespace App\Controllers;

use App\Models\PageModel;

class PageController extends AppController
{
    public $name = 'Page';
    protected $Page;

    public function initialize()
    {
        $this->Page = new PageModel();
        //$this->Page->read();
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
