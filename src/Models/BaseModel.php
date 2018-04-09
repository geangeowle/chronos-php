<?php

namespace Chronos\Models;

abstract class BaseModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->initialize();
    }

    abstract public function initialize();

    abstract public function read();
}
