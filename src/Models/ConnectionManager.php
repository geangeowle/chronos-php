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

    private static $instance = null;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function setConfig($useDbConfig, $namespace)
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
        $_this = static::getInstance();
        if (!isset($_this->dataSources[$_this->useDbConfig])) {
            foreach ($_this->config as $configName => $config) {
                $_this->connectionsPaths[$configName] = $_this->getConfigPaths($config);

                $_namespace = $_this->connectionsPaths[$configName]['namespace'];
                $_this->dataSources[$configName] = new $_namespace();
                $_this->dataSources[$configName]->setConfig($config);
                $_this->dataSources[$configName]->connect();
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
