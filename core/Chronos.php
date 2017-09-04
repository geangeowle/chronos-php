<?php
namespace Chronos;

use Chronos\Base\Dispatcher;

//use .....

final class Chronos
{
    private $appConfig = array();
    
    public function __construct($newAppConfig = array()){
      $this->setConfig($newAppConfig);
    }

    public function setConfig($newAppConfig = array()){
      $this->appConfig = $newAppConfig;
    }

    public function run()
    {
        $objDispatcher = new Dispatcher();
        $objDispatcher->setConfig($this->appConfig);
        $objDispatcher->dispatch();
    }
}
