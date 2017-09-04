<?php
namespace Chronos\Base;
use Chronos\Utils\Inflector;
use Chronos\Base\BaseObject;

class App extends BaseObject
{
  public function import($type = "", $file)
  {
      $nameFile = Inflector::camelize($file . "_controller");
      $appConfig = $this->getConfig();
      $pathCore = $appConfig["CHRONOS_PATH"] . "/Controllers/{$nameFile}.php";
      $pathApp = $appConfig["APP_PATH"] . "/Controllers/{$nameFile}.php";
      $path = (file_exists($pathApp)) ? $pathApp : $pathCore;
      require_once($path);
  }
}
