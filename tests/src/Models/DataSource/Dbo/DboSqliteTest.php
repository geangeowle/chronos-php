<?php

use Chronos\Models\DataSources\Dbo\DboSqlite;

/**
 * @coversNothing
 */
class DboSqliteTest extends PHPUnit\Framework\TestCase
{
    /**
     * [testEnable description].
     *
     * @return [type] [description]
     */
    public function testEnableReturnsEnable()
    {
        $config = [
            'datasource' => 'dbo',
            'driver' => 'sqlite',
            'database' => '/var/www/html/public/test',
            'prefix' => 'tb_',
        ];
        $dbo = new DboSqlite();
        // $dbo->setConfig($config);
        $this->assertTrue($dbo->enable());
    }

    public function testConnectionReturnsConnected()
    {
        $config = [
            'datasource' => 'dbo',
            'driver' => 'sqlite',
            'database' => dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/public/test',
            'prefix' => 'tb_',
        ];

        $dbo = new DboSqlite();
        $dbo->setConfig($config);
        $this->assertTrue($dbo->connect());
    }
}
