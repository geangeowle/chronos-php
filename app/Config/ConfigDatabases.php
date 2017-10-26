<?php

return
[
    'default' => [
        'datasource' => 'dbo',
        'driver' => 'sqlite',
        'database' => dirname(dirname(__DIR__)).'/public/test',
        'prefix' => 'tb_',
    ],
];
