<?php

    ini_set("display_errors", "1");
    error_reporting(E_ALL);
    date_default_timezone_set("America/Sao_Paulo");

    define("BASE_DIR", dirname(__DIR__));

    use Chronos\Chronos;
    require_once dirname(__DIR__) . "/vendor/autoload.php";
    //print_r(__DIR__);
    $app = Chronos::getInstance();
    $app->run();
