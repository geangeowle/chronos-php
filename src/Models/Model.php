<?php

namespace Chronos\Models;

use Chronos\Base\App;

class Model extends App
{
    public $useDbConfig = 'default';

    // public function __construct()
    // {
    //     //pr('....');
    // }

    public function find($type, $options = [])
    {
        pr('----begin -> find');
        pr($type);
        pr($options);

        $querySQL = '';
        $this->_execute($querySQL);

        pr('----end -> find');

        return [];
    }

    private function _execute($querySQL)
    {
        pr('####### querySQL');
        pr($querySQL);
        $connectionManager = new ConnectionManager($this->useDbConfig);
        $connectionManagerDataSource = $connectionManager->getConnection($this->useDbConfig);
        $result = $connectionManagerDataSource->query($querySQL);
        pr($result);

        return $result;
    }
}
