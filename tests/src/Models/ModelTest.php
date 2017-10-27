<?php

use Chronos\Models\Model;

/**
 * @coversNothing
 */
class ModelTest extends PHPUnit\Framework\TestCase
{
    private $model;

    public function setUp()
    {
        $this->model = new Model();
        $this->model->name = 'Test';
        $this->model->useTable = 'tb_test';
        $this->model->pk = 'id';

        $this->model->setTestMode(true);
    }

    public function testCheckSave()
    {
        $dadosSave = [
            // 'id' => '12',
            'ds' => 'rr208',
            // 'dt' => null,
            // 'dt' => 'null',
            // 'ds2' => '',
            // 'nr' => 0,
            // 'nr1' => '0',
            // 'nr2' => -1,
            // 'fl_true' => true,
            // 'fl_false' => false,
        ];

        $this->model->save($dadosSave);
        $actual = $this->model->getLastQuery();
        $expected = "INSERT INTO tb_test (ds) VALUES ('rr208')";
        $this->assertSame($expected, $actual);
    }
}
