<?php

namespace Chronos\Models;

use Chronos\Utils\Inflector;

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
            // 'default_another_server' => [
            //     'datasource' => '_dbo',
            //     'driver' => '_mysqli',
            //     'host' => '_host',
            //     'login' => '_login',
            //     'password' => '_password',
            //     'database' => '_database',
            //     'prefix' => '_prefix',
            // ],
        ];

        // added this in parse function
        if (!isset($_this->_dataSources[$useDbConfig])) {
            foreach ($this->config as $configName => $config) {
                $this->_connectionsPaths[$configName] = $this->_getConfigPaths($config);

                $_namespace = $this->_connectionsPaths[$configName]['namespace'];
                $this->_dataSources[$configName] = new $_namespace($config);
            }

            //pr($_this->_connectionsPaths);
        }

        // return $this->_dataSources[$useDbConfig];
    }

    public function getConnection($useDbConfig)
    {
        return $this->_dataSources[$useDbConfig];
    }

    private function _getConfigPaths($config)
    {
        $filename = '';
        $classname = '';

        $dsDataSource = Inflector::camelize($config['datasource']);
        $dsDriverName = Inflector::camelize($config['driver']);
        $dataClassName = ['Chronos', 'Models', 'DataSources'];
        $dataClassName[] = $dsDataSource;
        $dataClassName[] = "{$dsDataSource}{$dsDriverName}";

        $classname = implode('\\', $dataClassName);

        $_file = $filename;
        $_namespace = $classname;

        return ['file' => $_file, 'namespace' => $_namespace];
    }
}
