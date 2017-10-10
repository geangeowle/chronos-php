<?php

    ini_set('display_errors', '1');
    error_reporting(E_ALL);
    date_default_timezone_set('America/Sao_Paulo');

    define('APP_CONFIG', require_once dirname(__DIR__).'/app/Config/ConfigPaths.php');

    require_once dirname(__DIR__).'/vendor/autoload.php';
    require_once dirname(__DIR__).'/src/basics.php';
