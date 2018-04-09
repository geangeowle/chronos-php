<?php

namespace Chronos\Models;

use Chronos\Utils\Configure;
use Chronos\Utils\Inflector;

class ConnectionManager
{
    private $config;
    private $useDbConfig;
    private $namespace;
    private $dataSources = [];
    private $connectionsPaths = [];

    public function __construct($useDbConfig, $namespace)
    {
        $this->useDbConfig = $useDbConfig;
        $this->namespace = Inflector::camelize($namespace);
        $this->setDatabaseConfig();
    }

    public function getConnection($useDbConfig)
    {
        return $this->dataSources[$useDbConfig];
    }

    private function setDatabaseConfig()
    {
        $pathApp = Configure::read($this->namespace.'.Path');
        $pathFile = $pathApp.Configure::read($this->namespace.'.Database');
        $this->config = require $pathFile;

        $this->parseDatabaseConfig();
    }

    private function parseDatabaseConfig()
    {
        if (!isset($this->dataSources[$this->useDbConfig])) {
            foreach ($this->config as $configName => $config) {
                $this->connectionsPaths[$configName] = $this->getConfigPaths($config);

                $_namespace = $this->connectionsPaths[$configName]['namespace'];
                $this->dataSources[$configName] = new $_namespace();
                $this->dataSources[$configName]->setConfig($config);
                $this->dataSources[$configName]->connect();
            }
        }
    }

    private function getConfigPaths($config)
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
