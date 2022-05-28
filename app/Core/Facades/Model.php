<?php

namespace App\Core\Facades;

use App\Core\Support\Facade;

class Model extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Model::class;
    }
}
