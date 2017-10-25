<?php

namespace Chronos;

use Chronos\Base\BaseObject;
use Chronos\Base\Dispatcher;

require_once 'basics.php';

final class Chronos extends BaseObject
{
    public function run()
    {
        $objDispatcher = new Dispatcher();
        $objDispatcher->dispatch();
    }
}
