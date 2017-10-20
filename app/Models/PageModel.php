<?php

namespace App\Models;

class PageModel extends AppModel
{
    public $name = 'Page';
    public $useTable = 'tb_page';
    public $pk = 'id';

    public function r()
    {
        //$n = (new PageTestModel())->r();
        //$
        //$

        $dadosSave = [
            // 'id' => '12',
            'ds' => 'rr',
            // 'dt' => null,
            // 'dt' => 'null',
            // 'ds2' => '',
            // 'nr' => 0,
            // 'nr1' => '0',
            // 'nr2' => -1,
            // 'fl_true' => true,
            // 'fl_false' => false,
        ];
        // pr($this->save($dadosSave));

        pr('------------');
        $dadosUpd = [
            'id_fk' => 'null',
            'ds' => 'rr',
            'nr' => 0,
            'nr1' => '0',
            'nr2' => -1,
            'fl_true' => true,
            'fl_false' => false,
        ];
        $where = [
            'id IN ( 1, 2) ',
            // "ds IN ('ds', 'dsx')",
            // "( id = 2 OR ds IN ('y', 'x'))",
        ];
        pr($this->save($dadosUpd, $where));

        $dados = $this->find('all', [
            'conditions' => [
                // 'Page.id IN (1, 3, 4, 6)',
            ],
            'fields' => [
                'Page.id', 'Page.ds',
            ],
            'order' => [
                'Page.id DESC',
            ],
        ]);

        pr($dados);
        // pr($this->getConfig());
        // pr('..PageModel..');
    }
}
