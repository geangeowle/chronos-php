<?php

namespace Chronos\Models\DataSources;

abstract class DataSource
{
    public function __construct()
    {
        if (!$this->enable()) {
            trigger_error($this->getDescription().' is not enabled!');
        }
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
}
