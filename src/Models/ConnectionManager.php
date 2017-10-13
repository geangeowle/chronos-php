<?php

namespace Chronos\Models;

class ConnectionManager
{
    private $config;
    private $_dataSources = [];
    private $_connectionsPaths = [];

    public function __construct($useDbConfig)
    {
        //pr('___ConnectionManager');

        // change this
        $this->config = [
            'default' => [
                'datasource' => '_dbo',
                'driver' => '_sqlite',
                'host' => '_host',
                'login' => '_login',
                'password' => '_password',
                'database' => '_database',
                'prefix' => '_prefix',
            ],
        ];

        if (!isset($_this->_dataSources[$useDbConfig])) {
            //pr($this->config);
            foreach ($this->config as $configName => $config) {
                $_this->_connectionsPaths[$configName] = $this->_getConfigPaths($config);

                $_namespace = $_this->_connectionsPaths[$configName]['namespace'];
                $_this->_dataSources[$configName] = new $_namespace($config);
            }

            //pr($_this->_connectionsPaths);
        }
    }

    private function _getConfigPaths($config)
    {
        pr($config);

        $filename = '';
        $classname = '';

        // change this
        $classname = 'Chronos\\Models\\DataSources\\Dbo\\DboSqlite';

        $_file = $filename;
        $_namespace = $classname;

        return ['file' => $_file, 'namespace' => $_namespace];
    }
}
