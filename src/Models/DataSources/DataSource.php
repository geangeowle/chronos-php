<?php

namespace Chronos\Models\DataSources;

abstract class DataSource
{
    private $connected = false;

    public function __construct()
    {
        // if (!$this->enable()) {
        //     trigger_error($this->getDescription().' is not enabled!'.PHP_EOL, E_USER_ERROR);
        // }
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    abstract public function setConfig($newConfig = []);

    abstract public function getDescription();

    abstract public function enable();

    abstract public function connect();

    abstract public function disconnect();

    abstract public function query($querySql);

    abstract public function fetch();

    abstract public function getLastInsertedId();

    public function getConnected()
    {
        return $this->connected;
    }

    protected function setConnected($connected = false)
    {
        $this->connected = $connected;
    }
}
