<?php
namespace Chronos\Base;

use Chronos\Http\Router;
use Chronos\Utils\Inflector;
use Chronos\Base\App;

final class Dispatcher
{
  public $url = null;
  private $params = null;
  private $appConfig = array();

  public function __construct($url = null)
  {
    $this->url = (isset($_GET["url"])) ? $_GET["url"] : $url;
  }

  public function setConfig($newAppConfig = array()){
    $this->appConfig = $newAppConfig;
  }

  public function dispatch()
  {
      $this->params = Router::parse($this->url);
      $objController = $this->__getController();
      $objController->params = $this->params;
      $objController->appConfig = $this->appConfig;
      return $this->_invoke($objController, $this->params);
  }

  private function __getController(){
    $ctrlClass = "Chronos\\Controllers\\" . $this->__loadController($this->params);
    $objController = new $ctrlClass();
    return $objController;
  }

  private function __loadController($params){
    $name = $params["params"]["controller"];
    App::import("Controller", $name);
    return Inflector::camelize($name . "_controller");
  }

  public function _invoke(&$controller, $params)
  {
      $controller->output = $controller->render($params["params"]["action"]);
      if (isset($controller->output)) {
          echo ($controller->output);
      }
  }
}
