<?php

namespace App\Core\Facades;

use App\Core\Support\Facade;

class Validator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Validator::class;
    }
}
