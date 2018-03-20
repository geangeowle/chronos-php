<?php

namespace App\Models;

use Chronos\Models\Model;

abstract class AppModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->initialize();
    }

    abstract public function initialize();

    abstract public function read();
}
