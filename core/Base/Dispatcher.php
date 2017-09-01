<?php
namespace Chronos\Base;

use Chronos\Http\Router;
use Chronos\Utils\Inflector;
use Chronos\Base\App;

final class Dispatcher
{
  public $url = null;
  private $params = null;

  public function __construct($url = null)
  {
    $this->url = (isset($_GET["url"])) ? $_GET["url"] : $url;
    echo $this->url;
  }

  public function dispatch()
  {
      echo "<pre>";
      $this->params = Router::parse($this->url);
      print_r($this->params);

      $objController = $this->__getController();
  }

  private function __getController(){
    $ctrlClass = "Chronos\\Controllers\\" . $this->__loadController($this->params);
    $objController = new $ctrlClass();
  }

  private function __loadController($params){
    $name = $params["params"]["controller"];
    App::import("Controller", $name);
    return Inflector::camelize($name . "_controller");
  }
}
