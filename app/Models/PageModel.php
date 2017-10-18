<?php

namespace App\Models;

class PageModel extends AppModel
{
    public $name = 'Page';
    public $useTable = 'tb_page';

    public function r()
    {
        //$n = (new PageTestModel())->r();
        //$
        //$

        return $this->find('all', [
            'conditions' => [
                'Page.id IN (1, 3, 4, 6)',
            ],
            'fields' => [
                'Page.id', 'Page.ds',
            ],
        ]);
        // pr($this->getConfig());
        // pr('..PageModel..');
    }
}
