<?php

namespace Chronos\Models\DataSources\Dbo;

use Chronos\Models\DataSources\DataSource;

class DboSqlite extends DataSource
{
    public $conn;
    private $description = 'Driver DboSqlite';
    private $extension = 'sqlite3';
    private $config = [];

    private $connResource;
    private $results = [];

    public function setConfig($newConfig = [])
    {
        // make validations on $newConfig
        $this->config = $newConfig;
    }

    public function getDescription()
    {
        return sprintf('[%s] %s', $this->extension, $this->description);
    }

    public function enable()
    {
        return extension_loaded($this->extension);
    }

    public function connect()
    {
        try {
            $this->connResource = new \SQLite3($this->config['database'], SQLITE3_OPEN_READWRITE);
            $this->setConnected(true);
        } catch (Exception $e) {
            $this->setConnected(false);
        }
    }

    public function disconnect()
    {
        if (null !== $this->connResource) {
            $this->connResource->close();
        }
    }

    public function query($querySql)
    {
        $this->results = $this->connResource->query($querySql);
    }

    public function fetch()
    {
        $return = [];
        // change this
        if (false !== $this->results) {
            $cols = $this->results->numColumns();
            while ($row = $this->results->fetchArray(SQLITE3_ASSOC)) {
                $return[] = $row;
            }
        } else {
            // just for the moment
            pr($this->connResource->lastErrorMsg());
            die("Error in query: <span style='color:red;'>{$querySql}</span>");
        }

        return $return;
    }
}
