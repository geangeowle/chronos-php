<?php

namespace Chronos\Models\DataSources;

abstract class DataSource
{
    public function __construct()
    {
        if (!$this->enable()) {
            trigger_error($this->getDescription().' is not enable!');
        }
        pr('ok....->>>i am in '.__NAMESPACE__);
    }

    abstract public function getDescription();

    abstract public function enable();

    // abstract public function connect();
}
