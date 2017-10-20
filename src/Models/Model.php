<?php

namespace Chronos\Models;

use Chronos\Base\App;

class Model extends App
{
    public $useDbConfig = 'default';
    public $name = '';
    public $useTable = '';
    public $key = '';

    // public function __construct()
    // {
    //     //pr('....');
    // }

    public function find($type, $options = [])
    {
        $optionsDefault = [
            'conditions' => [],
            'fields' => [],
            'order' => [],
            'limit' => -1,
        ];
        $options = array_merge($optionsDefault, $options);

        if (empty($options['conditions'])) {
            $options['conditions'][] = '1=1';
        }

        if (empty($options['fields'])) {
            $options['fields'][] = $this->name.'.*';
        }

        if ('first' === $type) {
            $options['limit'] = 1;
        }

        $querySQL = sprintf(
            'SELECT %s FROM %s AS %s WHERE %s ',
            implode(', ', $options['fields']),
            $this->useTable,
            $this->name,
            implode(' AND ', $options['conditions'])
        );

        if (!empty($options['order'])) {
            $querySQL .= sprintf('ORDER BY %s ', implode(', ', $options['order']));
        }

        if ((int) ($options['limit']) >= 0) {
            $querySQL .= sprintf('LIMIT %s ', $options['limit']);
        }

        $result = $this->_execute($querySQL);

        return $result;
    }

    public function save($data, $where = [])
    {
        // pr($data);
        $querySQL = '';

        $flINSERT = (empty($data[$this->pk]) && empty($where));

        if ($flINSERT) {
            if (empty($data[$this->pk])) {
                unset($data[$this->pk]);
            }
        }

        foreach ($data as $k => $valor) {
            var_dump($valor);
            if (is_string($valor)) {
                $data[$k] = "'{$valor}'";
            } elseif (null === $valor) {
                $data[$k] = 'NULL';
            } elseif (is_bool($valor)) {
                $data[$k] = ($valor) ? 1 : 0;
            }
        }

        $campos = array_keys($data);
        $valores = array_values($data);

        if ($flINSERT) {
            $querySQL = sprintf(
                'INSERT INTO %s (%s) VALUES (%s)',
                $this->useTable,
                implode(', ', $campos),
                implode(', ', $valores)
            );
        } else {
            $dsWhere = implode(' AND ', $where);
            if (empty($where)) {
                $dsWhere = $this->pk.' = '.$data[$this->pk];
            }

            $camposSet = [];
            foreach ($campos as $k => $campo) {
                //if (! empty($camposDefault[$campo]) || $camposDefault[$campo] !== "0") {
                $camposSet[] = $campo.' = '.$valores[$k];
                //}
            }

            $querySQL = sprintf(
                'UPDATE SET %s WHERE '.$dsWhere,
                implode(', ', $camposSet)
                // $this->useTable,
                // implode(', ', $campos),
                // implode(', ', $valores)
            );
        }

        // pr($querySQL);

        $result = $this->_execute($querySQL);
    }

    private function _execute($querySQL)
    {
        // pr('####### querySQL');
        // pr($querySQL);
        $connectionManager = new ConnectionManager($this->useDbConfig);
        $connectionManagerDataSource = $connectionManager->getConnection($this->useDbConfig);
        $result = $connectionManagerDataSource->query($querySQL);
        //pr($result);
        // pr([$this->name => $result]);

        return $result;
    }
}
