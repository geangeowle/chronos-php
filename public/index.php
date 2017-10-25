<?php

    ini_set('display_errors', '1');
    error_reporting(E_ALL);
    date_default_timezone_set('America/Sao_Paulo');

    use Chronos\Chronos;
    use Chronos\Utils\Configure;

    require_once dirname(__DIR__).'/vendor/autoload.php';
    require_once dirname(__DIR__).'/app/Config/boot.php';

    // echo '<pre>';
    // var_dump(Configure::read('App.Path'));
    // var_dump(Configure::read('Chronos.Path'));

    // $appConfig = require_once dirname(__DIR__).'/app/Config/ConfigPaths.php';
    // $app = Chronos::getInstance();
    // $app->setConfig($appConfig);
    // $app->run();

    // (new Chronos($appConfig))->run();
    //
    (new Chronos())->run();
