<?php

namespace App\Core\Facades;

use App\Core\Facade;

class DB extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\DB::class;
    }
}
