<?php

namespace Chronos\Controllers;

use Chronos\Base\App;
use Chronos\Utils\Inflector;

class Controller extends App
{
    public $name = '';
    public $pageTitle = '';
    public $viewPath;
    public $viewVars = [];
    public $output;
    private $layout = 'default';

    public function __construct()
    {
        if (null === $this->viewPath) {
            $this->viewPath = Inflector::underscore($this->name);
        }
    }

    public function setLayout($newLayout)
    {
        $this->layout = $newLayout;
    }

    public function getLayout()
    {
        return $this->layout;
    }

    public function render($action = null, $layout = null, $file = null)
    {
        $viewClass = "Chronos\Views\View";
        $view = new $viewClass($this);
        $this->autoRender = false;
        $this->output .= $view->render($action, $layout, $file);

        return $this->output;
    }

    public function set($var, $value)
    {
        $this->viewVars[$var] = $value;
    }
}
