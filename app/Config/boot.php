<?php

use Chronos\Utils\Configure;

Configure::write('Chronos.Path', dirname(dirname(__DIR__)).'/src');

Configure::write('App.Path', dirname(dirname(__DIR__)).'/app');
Configure::write('App.Namespace', 'App');
Configure::write('App.RenderEngine', 'Default');
Configure::write('App.Database', '/Config/ConfigDatabases.php');
