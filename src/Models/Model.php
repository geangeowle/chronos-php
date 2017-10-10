<?php

namespace Chronos\Models;

use Chronos\Base\App;

class Model extends App
{
    public $useDbConfig = 'default';

    public function __construct()
    {
        //pr('....');
    }

    public function find($type, $options = [])
    {
        pr('----begin -> find');
        pr($type);
        pr($options);

        pr('----end -> find');

        return [];
    }

    private function _execute($querySQL)
    {
        pr($querySQL);

        return [];
    }
}
