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
        $ctrlClass = 'Chronos\\Controllers\\'.$this->__loadController($this->params);
        $objController = new $ctrlClass();

        return $objController;
    }

    private function __loadController($params)
    {
        $name = $params['params']['controller'];
        $this->import('Controller', $name);

        return Inflector::camelize($name.'_controller');
    }

    public function dispatch()
    {
        $this->params = Router::parse($this->url);
        $objController = $this->__getController();
        $objController->params = $this->params;
        $objController->setConfig($this->getConfig());

        return $this->_invoke($objController, $this->params);
    }

    public function _invoke(&$controller, $params)
    {
        $controller->output = $controller->render($params['params']['action']);
        if (isset($controller->output)) {
            echo $controller->output;
        }
    }
}
