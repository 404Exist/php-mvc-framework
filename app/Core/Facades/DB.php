<?php

namespace App\Core\Facades;

use App\Core\Support\Facade;

class DB extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\DB::class;
    }
}
