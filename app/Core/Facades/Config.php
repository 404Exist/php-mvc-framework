<?php

namespace App\Core\Facades;

use App\Core\Support\Facade;

class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Config::class;
    }
}
