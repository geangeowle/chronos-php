<?php
namespace Chronos;

use Chronos\Base\BaseObject;
use Chronos\Base\Dispatcher;

//use .....

final class Chronos extends BaseObject
{
    public function __construct($newAppConfig = array()){
      $this->setConfig($newAppConfig);
    }

    public function run()
    {
        $objDispatcher = new Dispatcher();
        $objDispatcher->setConfig($this->getConfig());
        $objDispatcher->dispatch();
    }
}
