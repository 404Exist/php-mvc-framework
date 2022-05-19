<?php

namespace App\Core\Facades;

use App\Core\Facade;

class Database extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Database::class;
    }
}
