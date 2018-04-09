<?php

namespace Chronos\Base;

use Chronos\Http\Router;
use Chronos\Utils\Inflector;

final class Dispatcher extends App
{
    private $url;
    private $params;

    public function __construct($url = null)
    {
        $this->url = (isset($_GET['url'])) ? $_GET['url'] : $url;
    }

    public function dispatch()
    {
        $this->params = Router::parse($this->url);
        $objController = $this->getControllerInstance();
        //pr($this->url);
        //pr($this->params);
        //die('...');
        $objController->setParams($this->params);

        return $this->invokeMethod($objController, $this->params);
    }

    private function getControllerFile($params)
    {
        $name = $params['url']['controller'];
        $namespace = $params['url']['namespace'];

        $this->import('Controller', $name, $namespace);

        return Inflector::camelize($name.'_controller');
    }

    private function getControllerInstance()
    {
        $ctrlClassName = $this->getControllerFile($this->params);
        $dsNamespace = Inflector::camelize($this->params['url']['namespace']);
        $ctrlClass = "{$dsNamespace}\\Controllers\\{$ctrlClassName}";

        if (!class_exists($ctrlClass)) {
            $this->url = '/error/missingClass/'.$ctrlClassName.'/'.$ctrlClass;
            $this->params = Router::parse($this->url);
            $ctrlClass = 'Chronos\\Controllers\\'.$this->getControllerFile($this->params);
        }
        $objController = new $ctrlClass();

        return $objController;
    }

    private function invokeMethod(&$controller, $params)
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
