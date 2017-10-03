<?php

namespace Chronos\Base;

use Chronos\Http\Router;
use Chronos\Utils\Inflector;

final class Dispatcher extends App
{
    public $url;
    private $params;

    public function __construct($url = null)
    {
        $this->url = (isset($_GET['url'])) ? $_GET['url'] : $url;
    }

    private function __getController()
    {
        pr($this->params);
        $ctrlClassName = $this->__loadController($this->params);
        $ctrlClass = 'App\\Controllers\\'.$ctrlClassName;
        pr($ctrlClass);
        if($ctrlClass == 'App\\Controllers\\ErrorController'){
            $ctrlClass = 'Chronos\\Controllers\\'.$ctrlClassName;
        }
        if (!class_exists($ctrlClass)) {
            $this->redirect("http://localhost:8056/public/?url=error/missingClass/{$ctrlClassName}");
            // $this->url = '/error/missingClass/'.$ctrlClassName;
            // $this->params = Router::parse($this->url);
            // // echo '<pre>';
            // // print_r($this->params);
            // $ctrlClass = 'Chronos\\Controllers\\'.$this->__loadController($this->params);
        }
        $objController = new $ctrlClass($this->getConfig());

        return $objController;
    }

    private function __loadController($params)
    {
        $name = $params['url']['controller'];
        $this->import('Controller', $name);

        return Inflector::camelize($name.'_controller');
    }

    public function dispatch()
    {
        $this->params = Router::parse($this->url);
        $objController = $this->__getController();
        $objController->params = $this->params;
        //$objController->setConfig($this->getConfig());

        return $this->_invoke($objController, $this->params);
    }

    public function _invoke(&$controller, $params)
    {
        if (method_exists($controller, 'dispatchMethod')) {
            $output = $controller->dispatchMethod($params['url']['action'], $params['url']['params']);
        }

        $controller->output = $controller->render($params['url']['action']);
        if (isset($controller->output)) {
            echo $controller->output;
        }
    }
}
