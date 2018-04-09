<?php

use Chronos\Chronos;
use Chronos\Utils\Configure;

Configure::write('Chronos.Path', dirname(dirname(__DIR__)).'/src');
Configure::write('Chronos.RenderEngine', 'Default');
Configure::write('Chronos.View.Folder', Chronos::CAMELCASE);
Configure::write('Chronos.View.File', Chronos::UNDERSCORE);

Configure::write('Default.Namespace', 'App');
Configure::write('Default.Path', 'app');

Configure::write('App.Database', '/Config/ConfigDatabases.php');
Configure::write('App.Namespace', 'App');
Configure::write('App.Path', dirname(dirname(__DIR__)).'/app');
Configure::write('App.RenderEngine', 'Default');
Configure::write('App.View.Folder', Chronos::CAMELCASE);
Configure::write('App.View.File', Chronos::UNDERSCORE);
