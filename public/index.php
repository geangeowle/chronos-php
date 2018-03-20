<?php

    ini_set('display_errors', '1');
    error_reporting(E_ALL);
    date_default_timezone_set('America/Sao_Paulo');

    require_once dirname(__DIR__).'/vendor/autoload.php';
    require_once dirname(__DIR__).'/app/requirements.php';

    use Chronos\Chronos;

    require_once dirname(__DIR__).'/app/Config/boot.php';

    (new Chronos())->run();
