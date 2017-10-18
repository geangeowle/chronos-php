<?php

namespace Chronos\Models;

use Chronos\Base\App;

class Model extends App
{
    public $useDbConfig = 'default';
    public $name = '';
    public $useTable = '';

    // public function __construct()
    // {
    //     //pr('....');
    // }

    public function find($type, $options = [])
    {
        pr('----begin -> find');
        pr($type);

        $optionsDefault = [
            'conditions' => [],
            'fields' => ['*'],
            'order' => [],
            'limit' => -1,
        ];
        $options = array_merge($optionsDefault, $options);

        if (empty($options['conditions'])) {
            $options['conditions'][] = '1=1';
        }

        if ('first' === $type) {
            $options['limit'] = 1;
        }

        pr($options);
        $querySQL = sprintf(
            'SELECT %s FROM %s AS %s WHERE %s',
            implode(', ', $options['fields']),
            $this->useTable,
            $this->name,
            implode(' AND ', $options['conditions'])
        );

        if (!empty($options['order'])) {
            $querySQL .= sprintf(' ORDER %s', implode(', ', $options['order']));
        }

        if ((int) ($options['limit']) >= 0) {
            $querySQL .= sprintf(' LIMIT %s', $options['limit']);
        }

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
