<?php

use Chronos\Models\DataSources\Dbo\DboSqlite;

/**
 * @coversNothing
 */
class DboSqliteTest extends PHPUnit\Framework\TestCase
{
    private $dbo;

    public function setUp()
    {
        $config = [
            'datasource' => 'dbo',
            'driver' => 'sqlite',
            'database' => dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/public/test',
            'prefix' => 'tb_',
        ];

        $this->dbo = new DboSqlite();
        $this->dbo->setConfig($config);
        $this->dbo->connect();
    }

    public function testCheckExtensionReturnsEnabled()
    {
        $this->assertTrue($this->dbo->enable());
    }

    public function testCheckConnectionReturnsConnected()
    {
        $this->assertTrue($this->dbo->getConnected());
    }
}
