<?php

use Chronos\Chronos;
use Chronos\Utils\Configure;

Configure::write('Chronos.Path', dirname(dirname(__DIR__)).'/src');
Configure::write('Chronos.RenderEngine', 'Default');
Configure::write('Chronos.View.Folder', Chronos::CAMELCASE);
Configure::write('Chronos.View.File', Chronos::UNDERSCORE);

Configure::write('Default.Namespace', 'Chronos');
Configure::write('Default.Path', 'src');
