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
    public function testEnable()
    {
        $dbo = new DboSqlite();
        $this->assertTrue($dbo->enable());
    }
}
