<?php
namespace Chronos\Controllers;

use Chronos\Base\App;
use Chronos\Utils\Inflector;
use Chronos\Views\View;

class Controller extends App
{

    public $name = "";
    public $viewPath = null;
    public $output = null;

    public function __construct(){
        if ($this->viewPath === null) {
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
