<?php

namespace Chronos\Controllers;

use Chronos\Base\App;
use Chronos\Utils\Inflector;

class Controller extends App
{
    public $name = '';
    public $pageTitle = '';
    public $viewVars = [];
    public $output;
    protected $params = [];
    private $layout = 'default';
    private $viewPath = 'page';

    public function __construct()
    {
        if ('page' === $this->getViewPath()) {
            $this->setViewPath(Inflector::underscore($this->name));
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

    public function setViewPath($newViewPath)
    {
        $this->viewPath = $newViewPath;
    }

    public function getViewPath()
    {
        return $this->viewPath;
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

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }
}
