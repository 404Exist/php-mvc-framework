<?php

namespace App\Core\Facades;

use App\Core\Facade;

class Model extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Model::class;
    }
}
