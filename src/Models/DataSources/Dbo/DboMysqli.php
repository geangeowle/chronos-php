<?php

namespace Chronos\Models\DataSources\Dbo;

use Chronos\Models\DataSources\DataSource;

class DboMysqli extends DataSource
{
    public $conn;
    private $description = 'Driver DboMysqli';
    private $extension = 'mysqli';
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
            $this->connResource = mysqli_connect($this->config['host'], $this->config['user'], $this->config['pass'], $this->config['port']);
            mysqli_select_db($this->connResource, $this->config['database']);

            if (!empty($this->config['encoding'])) {
                mysqli_query($this->connResource, "SET NAMES '{$this->config['encoding']}'");
            }

            $this->setConnected(true);
        } catch (Exception $e) {
            $this->setConnected(false);
        }
    }

    public function disconnect()
    {
        if (null !== $this->connResource) {
            @mysqli_close($this->connResource);
        }
    }

    public function query($querySql)
    {
        $this->results = @mysqli_query($this->connResource, $querySql);
    }

    public function fetch()
    {
        $return = [];
        // change this
        if (false !== $this->results) {
            while ($row = @mysqli_fetch_array($this->results, MYSQLI_ASSOC)) {
                $return[] = $row;
            }
        } else {
            // just for the moment
            $dsError = mysqli_error($this->connResource);
            pr($dsError);
            die("Error in query: <span style='color:red;'>{$dsError}</span>");
        }

        return $return;
    }

    public function getLastInsertedId()
    {
        $last_id = mysqli_insert_id($this->connResource);

        return (int) $last_id;
    }
}
