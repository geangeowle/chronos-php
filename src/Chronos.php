<?php

namespace Chronos;

use Chronos\Base\BaseObject;
use Chronos\Base\Dispatcher;

require_once 'basics.php';

final class Chronos extends BaseObject
{
    public function __construct($newAppConfig = [])
    {
        $this->setConfig($newAppConfig);
    }

    public function run()
    {
        $objDispatcher = new Dispatcher();
        $objDispatcher->setConfig($this->getConfig());
        $objDispatcher->dispatch();
    }
}
