<?php

namespace Chronos\Controllers;

use Chronos\Base\App;
use Chronos\Utils\Inflector;

class Controller extends App
{
    public $name = '';
    public $pageTitle = '';
    public $viewPath;
    public $output;

    public function __construct($newConfig = [])
    {
        $this->setConfig($newConfig);
        if (null === $this->viewPath) {
            $this->viewPath = Inflector::underscore($this->name);
        }
    }

    public function render($action = null, $layout = null, $file = null)
    {
        //$this->beforeRender();
        //$viewClass = $this->view;
        $viewClass = "Chronos\Views\View";

        $view = new $viewClass($this);

        $this->autoRender = false;
        $this->output .= $view->render($action, $layout, $file);

        return $this->output;
    }
}
