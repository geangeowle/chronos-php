<?php
namespace Chronos\Controllers;

use Chronos\Utils\Inflector;
use Chronos\Views\View;

class Controller
{

    public $name = "";
    public $viewPath = null;
    public $output = null;
    private $appConfig = array();

    public function __construct(){
        if ($this->viewPath === null) {
            $this->viewPath = Inflector::underscore($this->name);
        }
    }

    public function setConfig($newAppConfig = array()){
      $this->appConfig = $newAppConfig;
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
