<?php

namespace Chronos\Models\DataSources\Dbo;

use Chronos\Models\DataSources\DataSource;

class DboPostgres extends DataSource
{
    public $conn;
    private $description = 'Driver DboPostgres';
    private $extension = 'pgsql';
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
            $conn = "host='{$this->config['host']}' port='{$this->config['port']}' dbname='{$this->config['database']}' ";
            $conn .= "user='{$this->config['user']}' password='{$this->config['pass']}'";

            // if(!$config['persistent']){
            $this->connResource = pg_connect($conn, PGSQL_CONNECT_FORCE_NEW);
            // } else {
            // $this->connResource = pg_pconnect($conn);
            // }
            // $this->connected = false;

            // $this->pid = pg_get_pid($this->connResource);

            $this->connected = true;
            $this->query("SET datestyle TO 'ISO, DMY';");
            $this->query('SET search_path TO '.$this->config['schema'].';');

            if (!empty($this->config['encoding'])) {
                $this->setEncoding($this->config['encoding']);
            }

            $this->setConnected(true);
        } catch (Exception $e) {
            $this->setConnected(false);
        }
    }

    public function disconnect()
    {
        if (null !== $this->connResource) {
            @pg_free_result($this->results);
            @pg_close($this->connResource);
        }
    }

    public function query($querySql)
    {
        if ($result = @pg_query($this->connResource, $querySql)) {
            $this->results = $result;

            return $this->results;
        }

        $errors = \SqlFormatter::format($querySql).'<br />';
        $errors .= pg_last_error($this->connResource).'<br />';
        exit($errors);
    }

    public function fetch()
    {
        $return = [];
        // change this
        if (false !== $this->results) {
            $return = pg_fetch_all($this->results);
        } else {
            // just for the moment
            $dsError = pg_last_error($this->connResource);
            pr($dsError);
            die("Error in query: <span style='color:red;'>{$dsError}</span>");
        }

        return $return;
    }

    public function getLastInsertedId()
    {
        $row = @pg_fetch_row($this->results);
        $last_id = !empty($row[0]) ? $row[0] : 0;

        return (int) $last_id;
    }

    private function setEncoding($encod = 'UTF-8')
    {
        return 0 === pg_set_client_encoding($this->connResource, $encod);
    }
}
