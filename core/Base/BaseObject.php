<?php
namespace Chronos\Base;

class BaseObject{

  private $appConfig = array();

  public function setConfig($newAppConfig = array()){
    $this->appConfig = $newAppConfig;
  }

  public function getConfig(){
    return $this->appConfig;
  }
}
