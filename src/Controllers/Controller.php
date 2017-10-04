<?php

namespace Chronos\Controllers;

use Chronos\Base\App;
use Chronos\Utils\Inflector;

//use Chronos\Models\Model as Model;

class Controller extends App
{
    public $name = '';
    public $pageTitle = '';
    public $viewPath;
    public $output;
    public $uses = [];

    public function __construct($newConfig = [])
    {
        $this->setConfig($newConfig);
        if (null === $this->viewPath) {
            $this->viewPath = Inflector::underscore($this->name);
        }
        //$this->loadModel($this->uses[0]);
        // $s = 'Chronos\\Models\\Model';
        // $t = new Model();
    }

    public function loadModel($modelName)
    {
        // pr($modelName);
        $nameCamelize = Inflector::camelize($modelName);
        //$nameCamelize = "{$nameCamelize}Model";
        // pr($this->import('Model', $nameCamelize));
        // $this->Error->
        // $this->ErrorModel->
        // pr($nameCamelize);
        // die("");
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
