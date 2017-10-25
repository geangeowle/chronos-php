<?php

    use Chronos\Utils\Configure;

    Configure::write('App.Path', dirname(dirname(__DIR__)).'/app');
    Configure::write('Chronos.Path', dirname(dirname(__DIR__)).'/src');

    Configure::write('App.Database', '/Config/ConfigDatabases.php');
