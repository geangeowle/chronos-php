<?php

  use Chronos\Chronos;
  require_once dirname(__DIR__) . "/vendor/autoload.php";

  $app = Chronos::getInstance();
  $app->run();

?>
