<?php

namespace App\Models;

class PageModel extends AppModel
{
    public function r()
    {
        //$n = (new PageTestModel())->r();
        //$
        //$

        return $this->find('first', ['conditions' => []]);
        // pr($this->getConfig());
        // pr('..PageModel..');
    }
}
