<?php

namespace App\Models;

use Chronos\Models\Model;

abstract class AppModel extends Model
{
    abstract public function r();
}
