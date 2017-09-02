<?php
namespace Chronos;

use Chronos\Base\Dispatcher;

//use .....

final class Chronos
{
    private static $instance = null;
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function run()
    {
        $objDispatcher = new Dispatcher();
        $objDispatcher->dispatch();
    }
}
