<?php

    ini_set("display_errors", "1");
    error_reporting(E_ALL);
    date_default_timezone_set("America/Sao_Paulo");

    use Chronos\Chronos;
    require_once dirname(__DIR__) . "/vendor/autoload.php";

    $app = Chronos::getInstance();
    $app->run();
