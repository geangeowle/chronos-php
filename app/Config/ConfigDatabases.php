<?php

return
[
    'default' => [
        'datasource' => 'dbo',
        'driver' => 'sqlite',
        'database' => dirname(dirname(__DIR__)).'/db/test',
        'prefix' => 'tb_',
    ],
];
