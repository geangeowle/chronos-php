<?php

namespace Chronos\Models;

use Chronos\Utils\Configure;
use Chronos\Utils\Inflector;

class ConnectionManager
{
    private $config;
    private $useDbConfig;
    private $_dataSources = [];
    private $_connectionsPaths = [];

    public function __construct($useDbConfig)
    {
        $this->useDbConfig = $useDbConfig;
        $this->setDatabaseConfig();
    }

    public function getConnection($useDbConfig)
    {
        return $this->_dataSources[$useDbConfig];
    }

    private function setDatabaseConfig()
    {
        $pathApp = Configure::read('App.Path');
        $pathFile = $pathApp.Configure::read('App.Database');
        $this->config = require $pathFile;

        $this->parseDatabaseConfig();
    }

    private function parseDatabaseConfig()
    {
        if (!isset($this->_dataSources[$this->useDbConfig])) {
            foreach ($this->config as $configName => $config) {
                $this->_connectionsPaths[$configName] = $this->_getConfigPaths($config);

                $_namespace = $this->_connectionsPaths[$configName]['namespace'];
                $this->_dataSources[$configName] = new $_namespace();
                $this->_dataSources[$configName]->setConfig($config);
                $this->_dataSources[$configName]->connect();
            }
        }
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
