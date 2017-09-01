<?php

namespace Chronos;

//use .....

class Chronos
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
    die("<h1>It's a live!</h1>");
  }
}

?>
