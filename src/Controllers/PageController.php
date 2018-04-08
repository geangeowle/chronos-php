<?php

namespace Chronos\Controllers;

final class PageController extends BaseController
{
    public function initialize()
    {
        //$this->Page = new PageModel();
    }

    public function index()
    {
        $this->set('varX', 'dataX');
    }
}
