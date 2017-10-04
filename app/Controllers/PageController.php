<?php

namespace App\Controllers;

use App\Models\PageModel;

class PageController extends AppController
{
    public $name = 'Page';
    public $pageTitle = 'ChronosPHP';

    public function init()
    {
        $n = (new PageModel())->r();
        // $n = (new UserModel())->r();
    }

    public function index()
    {
    }

    public function getX()
    {
        return 1;
    }
}
