<?php

namespace App\Core\Facades;

use App\Core\Facade;

class Validator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Validator::class;
    }
}
