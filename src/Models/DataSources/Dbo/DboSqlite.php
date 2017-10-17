<?php

namespace Chronos\Models\DataSources\Dbo;

use Chronos\Models\DataSources\DataSource;

class DboSqlite extends DataSource
{
    private $description = 'Driver DboSqlite';
    private $extension = 'sqlite3';

    public function getDescription()
    {
        return sprintf('[%s] %s', $this->extension, $this->description);
    }

    public function enable()
    {
        return extension_loaded($this->extension);
    }

    public function connect()
    {
        //$dbhandle = sqlite_open('db/test.db', 0666, $error);
        //try {
        //$dbhandle = new \SQLite3('/var/www/html/public/test');
        // } catch (Exception $e) {
        //     die($e->getMessage());
        // }
    }

    public function query()
    {
        return [$this->getDescription()];
    }
}
