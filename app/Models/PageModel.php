<?php

namespace App\Models;

class PageModel extends AppModel
{
    public function r()
    {
        $n = (new PageTestModel())->r();

        // pr($this->getConfig());
        // pr('..PageModel..');
    }
}
