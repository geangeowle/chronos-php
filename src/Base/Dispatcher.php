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
        $this->import('Controller', $name);

        return Inflector::camelize($name.'_controller');
    }

    private function getControllerInstance()
    {
        //pr($this->params);
        $ctrlClassName = $this->getControllerFile($this->params);
        $dsNamespace = Inflector::camelize($this->params['url']['namespace']);
        $ctrlClass = "{$dsNamespace}\\Controllers\\{$ctrlClassName}";
        //pr($ctrlClass);
        // if ('App\\Controllers\\ErrorController' === $ctrlClass) {
        //     $ctrlClass = 'Chronos\\Controllers\\'.$ctrlClassName;
        // }
        if (!class_exists($ctrlClass)) {
            //$this->redirect("http://localhost:8056/public/?url=error/missingClass/{$ctrlClassName}");
            // $this->url = '/error/missingClass/'.$ctrlClassName;
            // $this->params = Router::parse($this->url);
            echo '<pre>';
            print_r($this->params);
            die('!class_exists -> '.$ctrlClassName);
            // $ctrlClass = 'Chronos\\Controllers\\'.$this->__loadController($this->params);
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
