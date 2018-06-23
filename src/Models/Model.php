<?php

namespace Chronos\Models;

use Chronos\Base\App;
use Chronos\Pagination\Engine\DefaultPaginationEngine;
use Chronos\Pagination\Pagination;

class Model extends App
{
    public $namespace = 'chronos';
    public $belongsTo = [];

    protected $name = '';
    protected $useTable = '';
    protected $key = '';

    private $useDbConfig = 'default';
    private $connectionManager;
    private $lastQuery = '';

    public function __construct()
    {
    }

    /**
     * Return records from a database, if the first parameter is set to 'first'
     * it will limit the records returned to ONE record, but if its set to
     * 'all', it will return all records.
     *
     * @param string $type
     * @param array  $options
     */
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
            'SELECT %s FROM %s AS %s %s WHERE %s ',
            implode(', ', $options['fields']),
            $this->useTable,
            $this->name,
            implode('', $this->buildBelongsTo()),
            implode(' AND ', $options['conditions'])
        );

        if (!empty($options['order'])) {
            $querySQL .= sprintf('ORDER BY %s ', implode(', ', $options['order']));
        }

        if ((int) ($options['limit']) >= 0) {
            $querySQL .= sprintf('LIMIT %s ', $options['limit']);
        }

        $querySQL .= ';';
        $result = $this->executeQuery($querySQL);
        $result = $this->fetch();

        if ('first' === $type) {
            $result = isset($result[0]) ? $result[0] : [];
        }

        return $result;
    }

    /**
     * Paginate method works similarly to find, but it will
     * return a pagination object.
     *
     * @param mixed $criteria
     *
     * @return Chronos\Pagination\Pagination
     */
    public function paginate($criteria = [], \Closure $config = null)
    {
        $pagination = new Pagination(new DefaultPaginationEngine());
        $conditions = [];

        // Define some default pagination configuration
        $currentPage = !empty($_GET['page']) ? (int) $_GET['page'] : 1;
        $pagination->setCurrentPage($currentPage);

        // Apply custom configurations to pagination object
        if (isset($config) && $config instanceof \Closure) {
            $config($pagination);
        }

        // Get conditions to obtain the total records
        if (!empty($criteria['conditions'])) {
            $conditions = $criteria['conditions'];
        }

        // Get the total number of records found
        $pages = $this->find('first', [
            'fields' => ['COUNT(1) AS nr_total'],
            'conditions' => $conditions,
        ]);

        // Stores the total number of records found
        if (!empty($pages['nr_total'])) {
            $pagination->setTotalRecords((int) $pages['nr_total']);
        }

        // Define the limit and offset to execute the pagination
        $criteria['limit'] = "{$pagination->getLimit()} OFFSET {$pagination->getOffset()}";

        // Get the records that will be displayed
        $records = $this->find('all', $criteria);
        $records = !empty($records) ? $records : [];

        // Store the records found inside pagination
        $pagination->setRecords($records);

        // Returns the pagination object
        return $pagination;
    }

    /**
     * Insert records into a database.
     *
     * @param array $data
     */
    public function insert($data)
    {
        $querySQL = '';

        $data = $this->makeData($data);

        if (empty($data[$this->pk])) {
            unset($data[$this->pk]);
        }

        $fields = array_keys($data);
        $values = array_values($data);

        $querySQL = sprintf(
            "INSERT INTO %s (%s) VALUES (%s) RETURNING {$this->pk};",
            $this->useTable,
            implode(', ', $fields),
            implode(', ', $values)
        );

        return $this->executeQuery($querySQL);
    }

    /**
     * Update records from a database.
     *
     * @param array $data
     * @param array $where
     */
    public function update($data, $where = [])
    {
        $querySQL = '';
        $data = $this->makeData($data);
        $whereCondition = implode(' AND ', $where);

        if (empty($where)) {
            $whereCondition = "{$this->pk} = {$data[$this->pk]}";
        }

        $fields = array_keys($data);
        $values = array_values($data);
        $fieldsSet = [];

        foreach ($fields as $k => $field) {
            $fieldsSet[] = "{$field} = {$values[$k]}";
        }

        $querySQL = sprintf(
            "UPDATE %s SET %s WHERE {$whereCondition};",
            $this->useTable,
            implode(', ', $fieldsSet)
        );

        return $this->executeQuery($querySQL);
    }

    /**
     * Insert or udpate records of a database.
     *
     * @param array $data
     * @param array $where
     */
    public function save($data, $where = [])
    {
        $isInsert = (empty($data[$this->pk]) && empty($where));

        if ($isInsert) {
            return $this->insert($data);
        }

        return $this->update($data, $where);
    }

    /**
     * Delete records from a database.
     *
     * @param int   $id
     * @param array $where
     */
    public function del($id, $where = [])
    {
        $whereCondition = implode(' AND ', $where);

        if (empty($where)) {
            $whereCondition = $this->pk.' = '.$id;
        }

        $querySQL = sprintf(
            "DELETE FROM %s WHERE {$whereCondition};",
            $this->useTable
        );

        $result = $this->executeQuery($querySQL);
    }

    /**
     * Returns the last query executed.
     *
     * @return string
     */
    public function getLastQuery()
    {
        return $this->lastQuery;
    }

    /**
     * Returns the last inserted id into a database, this method is usually
     * executed after an SQL INSERT is executed.
     *
     * @return resource
     */
    public function getLastInsertedId()
    {
        return $this->getConnectionResource()->getLastInsertedId();
        // return (int) $this->lastInsertedId;
    }

    /**
     * Defines which connection string should be used. It will call an array
     * from a collection of connections containing the information desired.
     * The string passed as an argument must match the index of
     * the connection information wanted.
     *
     * @param string $configString
     */
    public function setUseDbConfig($configString)
    {
        $this->useDbConfig = $configString;
    }

    /**
     * Helper method responsible for formatting the data passed to be
     * inserted or update in the correct way, so the
     * database won't complain.
     *
     * @param array $data
     */
    private function makeData($data = [])
    {
        foreach ($data as $k => $valor) {
            if (is_numeric($valor)) {
                $data[$k] = $valor;
            } elseif (null === $valor || 0 === strlen(trim($valor))) {
                $data[$k] = 'NULL';
            } elseif (is_bool($valor)) {
                $data[$k] = ($valor) ? 1 : 0;
            } else {
                $data[$k] = "'{$valor}'";
            }
        }

        return $data;
    }

    /**
     * Build the JOIN part in a select statement.
     */
    private function buildBelongsTo()
    {
        $joins = [];

        if (!empty($this->belongsTo)) {
            foreach ($this->belongsTo as $aliasModel => $dadosModelBelongsTo) {
                $kModel = $dadosModelBelongsTo['className'];
                $model = new $kModel();
                $tableName = $model->useTable;
                $primaryKey = $model->pk;
                $camposBelongsTo = !empty($dadosModelBelongsTo['fields']) ? $dadosModelBelongsTo['fields'] : '*';

                $refTable = !empty($dadosModelBelongsTo['refTable']) ? $dadosModelBelongsTo['refTable'] : $this->name;
                $conditionsLeft = !empty($dadosModelBelongsTo['conditions']) ? ' AND '.implode(' AND ', $dadosModelBelongsTo['conditions']) : '';
                $primaryKey = !empty($dadosModelBelongsTo['refColumn']) ? $dadosModelBelongsTo['refColumn'] : $primaryKey;
                $join = !empty($dadosModelBelongsTo['join']) ? $dadosModelBelongsTo['join'] : 'LEFT';
                $joins[] = sprintf(' %s JOIN %s as %s ON %s = %s %s', $join, $tableName, $aliasModel, "{$aliasModel}.{$primaryKey}", "{$refTable}.{$dadosModelBelongsTo['foreignKey']}", $conditionsLeft);
            }
        }

        return $joins;
    }

    /**
     * Class helper method responsible for fetching records from a database.
     */
    private function fetch()
    {
        return $this->getConnectionResource()->fetch();
    }

    /**
     * Method responsible for connecting to the database and returning a
     * resource to be used for executing CRUD operations.
     */
    private function getConnectionResource()
    {
        if (null === $this->connectionManager) {
            $this->connectionManager = ConnectionManager::getInstance();
            $this->connectionManager->setConfig($this->useDbConfig, $this->namespace);
        }
        $connectionManagerDataSource = $this->connectionManager->getConnection($this->useDbConfig);

        return $connectionManagerDataSource;
    }

    /**
     * Helper method for executing an statement into database.
     *
     * @param mixed $querySQL
     */
    private function executeQuery($querySQL)
    {
        $this->lastQuery = $querySQL;

        return $this->getConnectionResource()->query($querySQL);
    }
}
